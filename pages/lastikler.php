<?php
echo !defined("Secure-MENEKSELASTIK-2025@!") ? die("Hatalı sayfa girişi yaptınız. Lütfen site menüsünü kullanınız.") : null;
?>
<title><?= $seo_settings_arr['title'] ?></title>
<meta name="description" content="<?= $seo_settings_arr['description'] ?>" />
<meta property="og:title" content="<?= $seo_settings_arr['title'] ?>" />
<meta property="og:description" content="<?= $seo_settings_arr['description'] ?>" />
</head>

<body>
    <?php include("layouts/mobile-menu.php"); ?>

    <div class="l-theme animated-css" data-header="sticky" data-header-top="200" data-canvas="container">
        <?php include("layouts/header.php"); ?>

        <div class="section-title-page area-bg area-bg_dark area-bg_op_70">
            <div class="area-bg__inner">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="b-title-page bg-primary_a">Lastikler</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">

                <div class="col-md-9">
                    <main class="l-main-content">
                        <?php
                        // ----------------------------
                        // Pagination
                        // ----------------------------
                        $limit = 5;
                        $page  = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                        if ($page < 1) $page = 1;
                        $offset = ($page - 1) * $limit;

                        // ----------------------------
                        // Filters (GET)
                        // ----------------------------
                        $q = trim($_GET['q'] ?? '');

                        $filter_width     = isset($_GET['width']) ? (int)$_GET['width'] : 0;
                        $filter_height    = isset($_GET['height']) ? (int)$_GET['height'] : 0;
                        $filter_diameter  = isset($_GET['diameter']) ? (int)$_GET['diameter'] : 0;

                        $filter_manufacturer_id = isset($_GET['manufacturer_id']) ? (int)$_GET['manufacturer_id'] : 0;
                        $filter_season          = trim($_GET['season'] ?? '');

                        // runflat: "" | "1" | "0"
                        $filter_runflat_raw = $_GET['runflat'] ?? "";
                        $filter_runflat = ($filter_runflat_raw === "0" || $filter_runflat_raw === "1") ? (int)$filter_runflat_raw : null;

                        $filter_vehicle_types = [];
                        if (isset($_GET['vehicle_types']) && is_array($_GET['vehicle_types'])) {
                            $filter_vehicle_types = array_values(array_filter(array_map('intval', $_GET['vehicle_types']), fn($v) => $v > 0));
                        }

                        // ----------------------------
                        // Dynamic SQL
                        // ----------------------------
                        $joins  = [];
                        $where  = [];
                        $params = [];

                        // keyword
                        if ($q !== '') {
                            $where[] = "t.model LIKE :q";
                            $params[':q'] = "%{$q}%";
                        }

                        // manufacturer
                        if ($filter_manufacturer_id > 0) {
                            $where[] = "t.manufacturer_id = :mid";
                            $params[':mid'] = $filter_manufacturer_id;
                        }

                        // season
                        if ($filter_season !== '') {
                            $where[] = "t.season = :season";
                            $params[':season'] = $filter_season;
                        }

                        // runflat
                        if ($filter_runflat !== null) {
                            $where[] = "t.run_flat = :runflat";
                            $params[':runflat'] = $filter_runflat;
                        }

                        // size filters => join tire_sizes
                        if ($filter_width > 0 || $filter_height > 0 || $filter_diameter > 0) {
                            $joins[] = "INNER JOIN tire_sizes ts ON ts.tire_id = t.id";
                            if ($filter_width > 0) {
                                $where[] = "ts.width = :w";
                                $params[':w'] = $filter_width;
                            }
                            if ($filter_height > 0) {
                                $where[] = "ts.aspect_ratio = :h";
                                $params[':h'] = $filter_height;
                            }
                            if ($filter_diameter > 0) {
                                $where[] = "ts.rim_diameter = :d";
                                $params[':d'] = $filter_diameter;
                            }
                        }

                        // vehicle type filters => join tire_vehicle_type
                        if (!empty($filter_vehicle_types)) {
                            $joins[] = "INNER JOIN tire_vehicle_type tvt ON tvt.tire_id = t.id";
                            $in = [];
                            foreach ($filter_vehicle_types as $k => $vt) {
                                $ph = ":vt{$k}";
                                $in[] = $ph;
                                $params[$ph] = $vt;
                            }
                            $where[] = "tvt.vehicle_type_id IN (" . implode(',', $in) . ")";
                        }

                        $joinSql  = $joins ? "\n" . implode("\n", array_unique($joins)) . "\n" : "";
                        $whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

                        // COUNT (distinct)
                        $sqlCount = "
                        SELECT COUNT(DISTINCT t.id)
                        FROM tires t
                        $joinSql
                        $whereSql
                    ";
                        $stmtCount = $pdo->prepare($sqlCount);
                        foreach ($params as $k => $v) $stmtCount->bindValue($k, $v);
                        $stmtCount->execute();
                        $totalCount = (int)$stmtCount->fetchColumn();

                        $totalPages = (int)ceil(max(1, $totalCount) / $limit);
                        if ($page > $totalPages) $page = $totalPages;
                        $offset = ($page - 1) * $limit;

                        // LIST
                        $sqlList = "
                        SELECT DISTINCT t.*
                        FROM tires t
                        $joinSql
                        $whereSql
                        ORDER BY t.id DESC
                        LIMIT :limit OFFSET :offset
                    ";
                        $stmt = $pdo->prepare($sqlList);
                        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
                        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                        $stmt->execute();
                        $lastikIlanlari = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // shown range
                        if ($totalCount > 0) {
                            $start = $offset + 1;
                            $end   = min($offset + $limit, $totalCount);
                        } else {
                            $start = 0;
                            $end   = 0;
                        }

                        // vehicle types map (tek sorgu)
                        $vehicle_types_map = [];
                        $ids = array_column($lastikIlanlari, 'id');
                        if (!empty($ids)) {
                            $in = implode(',', array_fill(0, count($ids), '?'));
                            $vtStmt = $pdo->prepare("SELECT tire_id, vehicle_type_id FROM tire_vehicle_type WHERE tire_id IN ($in)");
                            $vtStmt->execute($ids);
                            foreach ($vtStmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
                                $vehicle_types_map[(int)$r['tire_id']][] = (int)$r['vehicle_type_id'];
                            }
                        }

                        // pagination query string builder (filters korunur)
                        $qs = $_GET;
                        unset($qs['page']); // her linkte yeniden ekleyeceğiz

                        function page_link($pageNo, $qs)
                        {
                            $qs['page'] = $pageNo;
                            $query = http_build_query($qs);
                            return "lastikler" . ($query ? ("?" . $query) : "");
                        }
                        ?>

                        <div class="filter-goods">
                            <div class="filter-goods__info">
                                Gösterilen sonuçlar:
                                <strong><?= $start ?> - <?= $end ?></strong>
                                / Toplam
                                <strong><?= $totalCount ?></strong>
                            </div>
                            <div class="filter-goods__select">
                                <div class="btns-switch">
                                    <i class="btns-switch__item js-view-th icon fa fa-th-large"></i>
                                    <i class="btns-switch__item js-view-list active icon fa fa-th-list"></i>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($lastikIlanlari)): ?>
                            <div class="goods-group-2 list-goods">
                                <?php foreach ($lastikIlanlari as $ilan): ?>
                                    <?php
                                    $tire_photo = substr($ilan['photo'], 3);

                                    $vehicle_types = $vehicle_types_map[(int)$ilan['id']] ?? [];

                                    $run_flat = ($ilan['run_flat'] == 1) ? "RFT" : "Standard";
                                    ?>
                                 <section class="b-goods-1">
                                        <div class="row">
                                            <div class="b-goods-1__img">
                                                <a class="js-zoom-images" href="<?= $tire_photo ?>">
                                                    <img class="img-responsive" src="<?= $tire_photo ?>" alt="foto" />
                                                </a>
                                            </div>
                                            <div class="b-goods-1__inner">
                                                <div class="b-goods-1__header"><span class="b-goods-1__price hidden-th"><?= $run_flat ?></span>
                                                    <h2 class="b-goods-1__name"><a href="lastik/<?= $ilan['model_link'] ?>"><?= $ilan['model'] ?></a>
                                                        <?php
                                                        if ($ilan['season'] == 'Yaz') {
                                                            echo '<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="tyre-search-sun">
                                <path d="M12 18.857a6.857 6.857 0 1 1 0-13.714 6.857 6.857 0 0 1 0 13.714zm0-12a5.143 5.143 0 1 0 0 10.286 5.143 5.143 0 0 0 0-10.286zm0-3.428a.857.857 0 0 1-.857-.858V.857a.857.857 0 0 1 1.714 0v1.714A.857.857 0 0 1 12 3.43zM4.723 5.94L3.514 4.723a.857.857 0 0 1 1.209-1.209L5.94 4.723A.86.86 0 1 1 4.723 5.94zM.857 12.857a.857.857 0 1 1 0-1.714h1.714a.857.857 0 0 1 0 1.714H.857zm3.866 5.203v.009a.857.857 0 0 1 1.208 1.208l-1.208 1.209a.857.857 0 1 1-1.209-1.209l1.209-1.217zm6.42 3.369a.857.857 0 0 1 1.714 0v1.714a.857.857 0 0 1-1.714 0v-1.714zm6.917-3.369a.857.857 0 0 1 1.209 0l1.208 1.209a.857.857 0 0 1-1.208 1.208L18.06 19.27a.857.857 0 0 1 0-1.209zm5.083-6.917a.857.857 0 1 1 0 1.714h-1.714a.857.857 0 0 1 0-1.714h1.714zm-4.474-4.954a.857.857 0 0 1-.609-1.466l1.217-1.209a.857.857 0 0 1 1.209 1.209L19.277 5.94a.857.857 0 0 1-.608.249z" fill="#CBCBCB" fill-rule="nonzero"></path>
                            </svg>';
                                                        } elseif ($ilan['season'] == 'Kış') {
                                                            echo '<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="tyre-search-winter">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Group" transform="translate(2.000000, 2.000000)" fill="#CBCBCB" fill-rule="nonzero">
                                        <path d="M17.5513204,12.9814462 L19.1056532,12.6194824 C19.4262265,12.562407 19.6840792,12.3540336 19.7748751,12.0786772 C19.8656711,11.8033209 19.7743791,11.5065669 19.537939,11.3084924 C19.3014988,11.1104178 18.9590533,11.0438138 18.6491678,11.1356308 L15.4012742,11.9045539 L11.7140133,10.0277416 L15.4001329,8.15792858 L18.6491678,8.92785158 C19.1063788,9.0137574 19.5602917,8.77089605 19.6819113,8.37529293 C19.8035309,7.9796898 19.5502531,7.56992715 19.1056532,7.44300007 L17.5513204,7.08203617 L19.5187725,6.09013536 C19.8090036,5.96109868 19.9940668,5.70208023 19.9997381,5.41696536 C20.0054094,5.13185049 19.8307599,4.86733918 19.5458369,4.72951982 C19.2609139,4.59170045 18.9123859,4.60314696 18.6400381,4.75926844 L16.6737272,5.75116925 L17.0868465,4.39030534 C17.1874775,4.11970635 17.1095284,3.82253928 16.8841568,3.61758663 C16.6587852,3.41263399 16.322755,3.33332881 16.0103829,3.41137067 C15.6980108,3.48941253 15.4602527,3.71207079 15.3921444,3.99034533 L14.51341,6.83606076 L10.8364202,8.69687468 L10.8364202,4.95924844 L13.2147091,2.87445692 C13.503027,2.5684218 13.4786414,2.12051457 13.1583852,1.83991479 C12.8381289,1.55931501 12.32692,1.53794905 11.9776337,1.79056531 L10.8364202,2.79046532 L10.8364202,0.797664602 C10.8480042,0.516160943 10.6832069,0.251586359 10.4067337,0.107822725 C10.1302606,-0.0359409084 9.78625216,-0.0359409084 9.50977901,0.107822725 C9.23330587,0.251586359 9.06850853,0.516160943 9.08009258,0.797664602 L9.08009258,2.79046532 L7.94800879,1.79056531 C7.59900764,1.53535913 7.08546711,1.55549792 6.7638829,1.83700151 C6.44229869,2.1185051 6.41884021,2.56843649 6.70979214,2.87445692 L9.08009258,4.95924844 L9.08009258,8.68887548 L5.39397298,6.82006236 L4.51523859,3.97434693 C4.45009684,3.69346939 4.21227449,3.46754592 3.89800267,3.38799296 C3.58373086,3.30844 3.24503742,3.38842758 3.01896941,3.59558996 C2.79290141,3.80275234 2.7168845,4.1027937 2.82167775,4.37430694 L3.23365583,5.73617075 L1.27647468,4.74327004 C0.860397878,4.55828242 0.351857718,4.69045759 0.118216062,5.04431418 C-0.115425594,5.39817076 0.00730113523,5.85032042 0.397740283,6.07413696 L2.36519235,7.06603777 L0.81085957,7.42800157 C0.493257148,7.48767618 0.239131123,7.6959933 0.150059793,7.96968519 C0.0609884622,8.24337708 0.151501651,8.53779754 0.385419768,8.73526195 C0.619337885,8.93272636 0.958502869,9.00102319 1.26734497,8.91285308 L4.51523859,8.14293008 L8.2024994,10.0277416 L4.5163798,11.8975546 L1.26734497,11.1276316 C0.958502869,11.0394615 0.619337885,11.1077583 0.385419768,11.3052227 C0.151501651,11.5026871 0.0609884622,11.7971076 0.150059793,12.0707995 C0.239131123,12.3444914 0.493257148,12.5528085 0.81085957,12.6124831 L2.36519235,12.973447 L0.398881496,13.973347 C0.016095015,14.199579 -0.101567099,14.6467894 0.129551581,14.9970168 C0.360670262,15.3472441 0.861726361,15.4810124 1.27647468,15.303214 L3.24278554,14.3123131 L2.82966625,15.6731771 C2.72903527,15.943776 2.80698433,16.2409431 3.03235591,16.4458958 C3.25772749,16.6508484 3.59375771,16.7301536 3.90612982,16.6521117 C4.21850193,16.5740699 4.45626001,16.3514116 4.52436829,16.0731371 L5.40310269,13.2274216 L9.08009258,11.3576086 L9.08009258,15.0892354 L6.70180365,17.1730271 C6.41052978,17.4788123 6.43351474,17.9287625 6.75480256,18.2105257 C7.07609038,18.492289 7.58960951,18.5128427 7.93887908,18.2579186 L9.08009258,17.2650179 L9.08009258,19.2578186 C9.09713518,19.6719701 9.48526667,20 9.95825637,20 C10.4312461,20 10.8193776,19.6719701 10.8364202,19.2578186 L10.8364202,17.2650179 L11.9685039,18.2579186 C12.3174602,18.5155795 12.8334476,18.4963222 13.1561324,18.2135946 C13.4788172,17.930867 13.5007962,17.478773 13.2067206,17.1730271 L10.8364202,15.0972346 L10.8364202,11.3596084 L14.5225398,13.2284215 L15.4012742,16.074137 C15.4664159,16.3550145 15.7042382,16.580938 16.0185101,16.6604909 C16.3327819,16.7400439 16.6714753,16.6600563 16.8975433,16.4528939 C17.1236113,16.2457315 17.1996282,15.9456902 17.094835,15.674177 L16.6828569,14.313313 L18.6491678,15.3052138 C19.0642849,15.4856281 19.5679586,15.3526067 19.8001293,15.0012421 C20.0323,14.6498776 19.9131703,14.2009343 19.5279022,13.9753468 L19.5187725,13.9753468 L17.5513204,12.9814462 Z" id="Path"></path>
                                    </g>
                                </g>
                            </svg>';
                                                        } else {
                                                            echo '<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="tyre-search-allseason">
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <path d="M5.5,12.1254664 C5.4975471,11.7919723 5.24931192,11.5252458 4.94125358,11.5279229 L1.04703263,11.5584685 C0.742317726,11.5605837 0.497580103,11.8310615 0.5,12.1645556 C0.502234693,12.495132 0.750515298,12.765033 1.0554061,12.7626609 L4.949627,12.7321154 C5.25750949,12.7296951 5.50220169,12.4560428 5.5,12.1254664" id="Fill-1" stroke-width="0.5" fill="#CBCBCB" fill-rule="nonzero"></path>
                                    <path d="M12.5046821,16.7868162 C12.4980279,16.7835515 12.4944099,16.7836699 12.487547,16.7833931 C11.2031594,16.6174574 10.0794134,15.9101074 9.3425613,14.8900854 C9.11304521,14.571849 8.92457531,14.2257454 8.77727012,13.8553924 C8.5634031,13.3130599 8.44227622,12.7219436 8.43763876,12.1028308 C8.4330859,11.51439 8.53246534,10.9492655 8.72091786,10.4284492 C8.85568156,10.0522893 9.03602129,9.6998236 9.25367558,9.37486105 C9.97510108,8.29980086 11.1156319,7.54454385 12.435519,7.35913343 C12.5119372,7.34793917 12.5900612,7.34033884 12.6682554,7.33318202 L12.6592779,6.13127715 C12.5821331,6.13644937 12.5038887,6.13611325 12.426162,6.14478714 C10.6592711,6.34371636 9.13214677,7.35613648 8.21055185,8.80771467 C7.99962202,9.1363855 7.81953914,9.48903779 7.67779417,9.86130286 C7.40445731,10.5551281 7.25846328,11.3167493 7.26430508,12.1113745 C7.27030177,12.9371152 7.44152199,13.7239582 7.7425152,14.4375137 C7.8967514,14.8042686 8.08503466,15.1506291 8.30736294,15.4722769 C9.25361297,16.8657734 10.7643805,17.8209534 12.4964123,17.994635 L12.5134289,17.9944401 C12.5905337,18.0033669 12.6686639,18.0087217 12.7469103,18.0133761 L12.7381877,16.8073395 C12.6597304,16.8013546 12.5817869,16.7957429 12.5046821,16.7868162" id="Fill-3" stroke-width="0.5" fill="#CBCBCB" fill-rule="nonzero"></path>
                                    <path d="M3.92298612,3.65418673 L5.33360647,5.08210163 L6.72404735,6.48593664 C6.98336114,6.68375778 7.35137749,6.62933383 7.54548786,6.35947511 C7.69876358,6.14471608 7.6966166,5.85274823 7.54028345,5.64066223 L4.58314865,2.65156452 C4.32339136,2.45381365 3.95612357,2.51152852 3.76488012,2.77797598 C3.60836217,2.99234163 3.61069782,3.28837101 3.77027578,3.50085228 L3.92298612,3.65418673 Z" id="Fill-5" stroke-width="0.5" fill="#CBCBCB" fill-rule="nonzero"></path>
                                    <path d="M6.83595469,17.1092893 L5.47685692,18.5267395 L4.02219428,20.0411537 L3.926491,20.1415492 C3.66993556,20.3428847 3.61778088,20.7182348 3.81552663,20.9851328 C4.01030646,21.2490909 4.37893219,21.2975374 4.63560605,21.0998198 C4.68003348,21.064598 4.72074649,21.0231455 4.75137385,20.9782898 L7.66408228,17.9464252 C7.88289961,17.7106074 7.88012953,17.3357737 7.65807733,17.103411 C7.4259677,16.8778693 7.06110115,16.8804245 6.83595469,17.1092893" id="Fill-8" stroke-width="0.5" fill="#CBCBCB" fill-rule="nonzero"></path>
                                    <path d="M23.7221024,6.10367373 C23.8503583,6.32361624 23.7764781,6.61489681 23.5597866,6.75650302 L21.2972518,8.20316623 L23.4067864,8.68369234 C23.6552021,8.74094969 23.8026361,8.99013128 23.7398505,9.24669616 C23.6740989,9.50032129 23.4249938,9.66115393 23.1766724,9.60592731 L20.1744677,8.92265394 L15.3815568,11.9934185 L20.2217251,14.6156283 L23.2120108,13.6565006 C23.4564394,13.5766456 23.7108461,13.7147821 23.7800116,13.9620403 C23.846424,14.2120075 23.7029939,14.4774811 23.4583305,14.5544184 L21.3572612,15.2295091 L23.6422738,16.4677914 C23.8612141,16.5872241 23.941182,16.8725488 23.8164558,17.1025561 C23.688836,17.3343855 23.409399,17.4256951 23.1877276,17.3062403 L20.9029718,16.0681446 L21.4869696,18.1968251 C21.5534039,18.4440612 21.4094382,18.7118927 21.1652182,18.7887598 C21.0413123,18.8302053 20.9177528,18.8149983 20.8147853,18.7590254 C20.7120747,18.7032389 20.6306564,18.606803 20.5974743,18.4834067 L19.76991,15.4540994 L14.927127,12.8311671 L14.9740112,18.5246552 L17.1877001,20.6659324 C17.3692729,20.8421988 17.3715865,21.1409593 17.1927577,21.333621 C17.013672,21.526096 16.7227598,21.5392135 16.5413737,21.3626902 L14.9869496,19.8577668 L15.008984,22.5427825 C15.0094233,22.6063191 14.9975936,22.6674248 14.9757934,22.7236986 C14.930465,22.902349 14.7688884,23.0349437 14.5757948,23.0361714 C14.5719616,23.0361989 14.56814,23.0361745 14.5643308,23.0360989 C14.560659,23.0358346 14.5564922,23.0360953 14.5523122,23.036468 L14.5412013,23.036468 C14.3269708,23.0186637 14.1577069,22.840743 14.1558976,22.6223915 L14.1558976,22.6223915 L14,1.45612022 C13.9983605,1.22612663 14.1836107,1.0381304 14.4136043,1.03646802 L14.3788881,1.03984463 L14.3791973,1.03646802 L14.3992885,1.03776517 L14.4136043,1.03646802 C14.6184372,1.03495039 14.7897367,1.18115099 14.8264336,1.37519072 L14.833688,1.45000298 L14.8509098,3.78375655 L14.8549238,4.17360439 L16.3833081,2.52477175 C16.5598493,2.33201779 16.8531414,2.316705 17.0349008,2.49271456 C17.214256,2.66933212 17.216383,2.96834947 17.039585,3.16091683 L14.8648743,5.50650726 L14.9121318,11.1994817 L19.7077737,8.12873918 L20.4849063,5.02597642 C20.5477401,4.77258609 20.7995764,4.61177551 21.045283,4.66627976 C21.2930906,4.72113312 21.4405026,4.97304577 21.377739,5.2268796 L20.8313779,7.40803343 L23.0906406,5.9600218 C23.3104845,5.82109845 23.5938466,5.88373126 23.7221024,6.10367373 Z" id="Combined-Shape" stroke-width="0.5" fill="#CBCBCB" fill-rule="nonzero"></path>
                                </g>
                            </svg>';
                                                        }
                                                        ?> </h2>

                                                </div>
                                                <span class="b-goods-1__price_th text-primary visible-th"><?= $run_flat ?></span>
                                                <div class="b-goods-1__section">
                                                    <h3 class="b-goods-1__title" data-toggle="collapse" data-target="#desc-<?= (int)$ilan['id'] ?>">Uygun Araç Tipleri</h3>
                                                    <div class="collapse in" id="desc-<?= (int)$ilan['id'] ?>">
                                                        <ul class="b-goods-1__desc list-unstyled">
                                                            <?php foreach ($vehicle_types as $type_id): ?>
                                                                <?php if ($type_id === 1): ?>
                                                                    <li class="b-goods-1__desc-item"><img class="img-responsive" src="assets/media/cars/sedan.png" width="50" height="50"></li>
                                                                <?php elseif ($type_id === 2): ?>
                                                                    <li class="b-goods-1__desc-item"><img class="img-responsive" src="assets/media/cars/long-car.png" width="50" height="50"></li>
                                                                <?php elseif ($type_id === 3): ?>
                                                                    <li class="b-goods-1__desc-item"><img class="img-responsive" src="assets/media/cars/minibus-trip.png" width="50" height="50"></li>
                                                                <?php elseif ($type_id === 4): ?>
                                                                    <li class="b-goods-1__desc-item"><img class="img-responsive" src="assets/media/cars/transportation-truck.png" width="50" height="50"></li>
                                                                <?php elseif ($type_id === 5): ?>
                                                                    <li class="b-goods-1__desc-item"><img class="img-responsive" src="assets/media/cars/tractor-facing-right.png" width="50" height="50"></li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </section>
                                 
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">Aradığınız kriterlere uygun lastik bulunamadı.</div>
                        <?php endif; ?>

                        <?php if ($totalPages > 1): ?>
                            <ul class="pagination text-center">
                                <li class="<?= ($page <= 1) ? 'disabled' : '' ?>">
                                    <a href="<?= ($page <= 1) ? 'javascript:void(0)' : page_link($page - 1, $qs) ?>">
                                        <i class="icon fa fa-angle-double-left"></i>
                                    </a>
                                </li>

                                <?php
                                // Basit pencere: 1..totalPages (istersen 5'lik window yaparız)
                                for ($i = 1; $i <= $totalPages; $i++):
                                ?>
                                    <li class="<?= ($i == $page) ? 'active' : '' ?>">
                                        <a href="<?= page_link($i, $qs) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <li class="<?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                    <a href="<?= ($page >= $totalPages) ? 'javascript:void(0)' : page_link($page + 1, $qs) ?>">
                                        <i class="icon fa fa-angle-double-right"></i>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>

                    </main>
                </div>

                <div class="col-md-3">
                    <div class="l-sidebar">
                        <form class="b-filter-2 bg-grey" method="get" action="lastikler">
                            <h3 class="b-filter-2__title">
                                Gelişmiş Arama
                            </h3>
                            <div class="b-filter-2__inner">

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Kelime</div>
                                    <input class="form-control" type="text" name="q" placeholder="Model ara..."
                                        value="<?= htmlspecialchars($q) ?>" />
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Genişlik</div>
                                    <select class="selectpicker" name="width" data-width="100%">
                                        <option value="">Seçiniz</option>
                                        <?php foreach (range(145, 335, 10) as $w): ?>
                                            <option value="<?= $w ?>" <?= ($filter_width == $w) ? 'selected' : '' ?>><?= $w ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Yükseklik</div>
                                    <select class="selectpicker" name="height" data-width="100%">
                                        <option value="">Seçiniz</option>
                                        <?php foreach (range(30, 85, 5) as $h): ?>
                                            <option value="<?= $h ?>" <?= ($filter_height == $h) ? 'selected' : '' ?>><?= $h ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Çap</div>
                                    <select class="selectpicker" name="diameter" data-width="100%">
                                        <option value="">Seçiniz</option>
                                        <?php foreach (range(12, 20, 1) as $d): ?>
                                            <option value="<?= $d ?>" <?= ($filter_diameter == $d) ? 'selected' : '' ?>><?= $d ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Marka</div>
                                    <select class="selectpicker" name="manufacturer_id" data-width="100%">
                                        <option value="">Tüm Markalar</option>
                                        <?php
                                        $get_menufacturers = $pdo->query("SELECT * FROM manufacturers ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($get_menufacturers as $manufacturer):
                                        ?>
                                            <option value="<?= (int)$manufacturer['id'] ?>"
                                                <?= ((int)$manufacturer['id'] === $filter_manufacturer_id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($manufacturer['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Sezon</div>
                                    <select class="selectpicker" name="season" data-width="100%">
                                        <option value="">Tüm Sezonlar</option>
                                        <option value="Yaz" <?= ($filter_season === 'Yaz') ? 'selected' : '' ?>>Yaz</option>
                                        <option value="Kış" <?= ($filter_season === 'Kış') ? 'selected' : '' ?>>Kış</option>
                                        <option value="Dört Mevsim" <?= ($filter_season === 'Dört Mevsim') ? 'selected' : '' ?>>4 Mevsim</option>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">RunFlat</div>
                                    <select class="selectpicker" name="runflat" data-width="100%">
                                        <option value="">Tümü</option>
                                        <option value="1" <?= ($filter_runflat_raw === "1") ? 'selected' : '' ?>>Run Flat</option>
                                        <option value="0" <?= ($filter_runflat_raw === "0") ? 'selected' : '' ?>>Standard</option>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Araç Tipi</div>
                                    <div class="b-filter-type-2">
                                        <?php
                                        $vt_options = [
                                            1 => ['id' => 'typeCar', 'img' => 'assets/media/cars/sedan.png', 'title' => 'Otomobil'],
                                            2 => ['id' => 'type4x4', 'img' => 'assets/media/cars/long-car.png', 'title' => '4x4'],
                                            3 => ['id' => 'typeLight', 'img' => 'assets/media/cars/minibus-trip.png', 'title' => 'Hafif Ticari'],
                                            4 => ['id' => 'typeHeavy', 'img' => 'assets/media/cars/transportation-truck.png', 'title' => 'Ağır Vasıta'],
                                            5 => ['id' => 'typeTractor', 'img' => 'assets/media/cars/tractor-facing-right.png', 'title' => 'Traktör'],
                                        ];
                                        foreach ($vt_options as $vtId => $opt):
                                            $checked = in_array($vtId, $filter_vehicle_types, true);
                                        ?>
                                            <div class="b-filter-type-2__item">
                                                <input class="b-filter-type-2__input"
                                                    id="<?= $opt['id'] ?>"
                                                    type="checkbox"
                                                    name="vehicle_types[]"
                                                    value="<?= $vtId ?>"
                                                    <?= $checked ? 'checked' : '' ?> />
                                                <label class="b-filter-type-2__label" for="<?= $opt['id'] ?>">
                                                    <img class="img-responsive" src="<?= $opt['img'] ?>" width="50" height="50">
                                                    <span class="b-filter-type-2__title"><?= $opt['title'] ?></span>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="b-filter-2__group" style="margin-top: 15px;">
                                    <button type="submit" class="btn btn-primary btn-block">Ara</button>
                                    <a href="lastikler" class="btn btn-default btn-block" style="margin-top:10px;">Filtreleri Temizle</a>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>

            </div>