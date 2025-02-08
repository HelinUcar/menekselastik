// This is included with the Parsley library itself,
// thus there is no use in adding it to your project.


Parsley.addMessages('en', {
    defaultMessage: "Bu değer geçersiz görünüyor.",
    type: {
        email: "Bu değer geçerli bir e-posta olmalıdır.",
        url: "Bu değer geçerli bir url olmalıdır.",
        number: "Bu değer geçerli bir sayı olmalıdır.",
        integer: "Bu değer geçerli bir tam sayı olmalıdır.",
        digits: "Bu değer rakamlardan oluşmalıdır.",
        alphanum: "Bu değer alfanümerik olmalıdır."
    },
    notblank: "Bu değer boş olmamalıdır.",
    required: "Bu değer zorunludur.",
    pattern: "Bu değer geçersiz görünüyor.",
    min: "Bu değer %s'den büyük veya ona eşit olmalıdır.",
    max: "Bu değer %s'den küçük veya ona eşit olmalıdır.",
    range: "Bu değer %s ile %s arasında olmalıdır.",
    minlength: "Bu değer çok kısa. En az %s karakter içermelidir.",
    maxlength: "Bu değer çok uzun. En az %s karakter içermelidir.",
    length: "Bu değerin uzunluğu geçersiz. En az %s ve %s karakter içermelidir.",
    mincheck: "En az %s seçenek seçmelisiniz.",
    maxcheck: "%s veya daha az seçenek seçmelisiniz.",
    check: "%s ile %s seçenek arasında seçim yapmalısınız.",
    equalto: "Bu değer aynı olmalıdır.",
    euvatin: "Geçerli bir KDV Kimlik Numarası değil.",
});

Parsley.setLocale('en ');