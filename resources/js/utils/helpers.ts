import {Client, NoReadonly, TDevice} from "../types";
import swal from "sweetalert";

type TDeviceKind = {
  [key: string]: string
}

export type TCountryCallingCodes = {
  name: string,
  code: string,
  codeNumber: string
}

const DeviceKind: TDeviceKind = {
  videoinput: 'camera',
  audioinput: 'microphone',
  audiooutput: 'speaker'
}

export function errorHandler(err: any, $callback?: Function) {
  if (err.data.error) {
    console.warn('Login', err.data.error);
    swal({
      title: "Ops!",
      text: err.data.error,
      icon: "warning",
    })
  } else if (err.data.errors) {
    console.error('Login', err.data.errors);
    if ($callback) {
      for (const error in err.data.errors) {
        $callback(error, err.data.errors[error][0]);
        swal({
          title: error,
          text: err.data.errors[error][0],
          icon: "warning",
        })
      }
    }
  } else if (err.data.message) {
    swal({
      title: "Ops!",
      text: err.data.message,
      icon: "warning",
    })
  } else {
    swal({
      title: "Ops!",
      text: err.statusText,
      icon: "error",
    })
  }
}

export function getFilteredDevices(array: MediaDeviceInfo[], filter: string): TDevice[] {
  const countDevice: number = 1;
  let newArray: TDevice[]  = [];
  for (let i: number = 0; i < array.length; i++) {

    if (array[i].kind !== filter) continue;

    newArray.push({
      deviceId: array[i].deviceId,
      groupId: array[i].groupId,
      kind: array[i].kind,
      label: array[i].label || `${DeviceKind[filter]} ${countDevice}`,
    });
  }

  return newArray;
}

export function getCountryCallingCodes(): TCountryCallingCodes[] {
  return [
    {name: 'Австралия', code: 'AU', codeNumber:	'+61'},
    {name: 'Австрия', code: 'AT', codeNumber:	'+43'},
    {name: 'Азербайджан', code: 'AZ', codeNumber:	'+994'},
    {name: 'Албания', code: 'AL', codeNumber:	'+355'},
    {name: 'Ангола', code: 'AO', codeNumber:	'+244'},
    {name: 'Андорра', code: 'AD', codeNumber:	'+376'},
    {name: 'Антигуа и Барбуда', code: 'AG', codeNumber:	'+1268'},
    {name: 'Афганистан', code: 'AF', codeNumber:	'+54'},
    {name: 'Багамы', code: 'BS', codeNumber:	'+1242'},
    {name: 'Бангладеш', code: 'BD', codeNumber:	'+880'},
    {name: 'Барбадос', code: 'BB', codeNumber:	'+1246'},
    {name: 'Бахрейн', code: 'BH', codeNumber:	'+973'},
    {name: 'Беларусь', code: 'BY', codeNumber:	'+375'},
    {name: 'Белиз', code: 'BZ', codeNumber:	'+229'},
    {name: 'Бельгия', code: 'BE', codeNumber:	'+359'},
    {name: 'Бенин', code: 'BJ', codeNumber:	'+229'},
    {name: 'Болгария', code: 'BG', codeNumber:	'+359'},
    {name: 'Боливия', code: 'BO', codeNumber:	'+591'},
    {name: 'Босния и Герцеговина', code: 'BA', codeNumber:	'+387'},
    {name: 'Ботсвана', code: 'BW', codeNumber:	'+267'},
    {name: 'Бразилия', code: 'BR', codeNumber:	'+55'},
    {name: 'Бруней', code: 'BN', codeNumber:	'+673'},
    {name: 'Буркина Фасо', code: 'BF', codeNumber:	'+226'}
  ]
}

  // "ad": "Andorra",
  // "ae": "United Arab Emirates",
  // "af": "Afghanistan",
  // "ag": "Antigua and Barbuda",
  // "ai": "Anguilla",
  // "al": "Albania",
  // "am": "Armenia",
  // "ao": "Angola",
  // "aq": "Antarctica",
  // "ar": "Argentina",
  // "as": "American Samoa",
  // "at": "Austria",
  // "au": "Australia",
  // "aw": "Aruba",
  // "ax": "Åland Islands",
  // "az": "Azerbaijan",
  // "ba": "Bosnia and Herzegovina",
  // "bb": "Barbados",
  // "bd": "Bangladesh",
  // "be": "Belgium",
  // "bf": "Burkina Faso",
  // "bg": "Bulgaria",
  // "bh": "Bahrain",
  // "bi": "Burundi",
  // "bj": "Benin",
  // "bl": "Saint Barthélemy",
  // "bm": "Bermuda",
  // "bn": "Brunei",
  // "bo": "Bolivia",
  // "bq": "Caribbean Netherlands",
  // "br": "Brazil",
  // "bs": "Bahamas",
  // "bt": "Bhutan",
  // "bv": "Bouvet Island",
  // "bw": "Botswana",
  // "by": "Belarus",
  // "bz": "Belize",
  // "ca": "Canada",
  // "cc": "Cocos (Keeling) Islands",
  // "cd": "DR Congo",
  // "cf": "Central African Republic",
  // "cg": "Republic of the Congo",
  // "ch": "Switzerland",
  // "ci": "Côte d'Ivoire (Ivory Coast)",
  // "ck": "Cook Islands",
  // "cl": "Chile",
  // "cm": "Cameroon",
  // "cn": "China",
  // "co": "Colombia",
  // "cr": "Costa Rica",
  // "cu": "Cuba",
  // "cv": "Cape Verde",
  // "cw": "Curaçao",
  // "cx": "Christmas Island",
  // "cy": "Cyprus",
  // "cz": "Czechia",
  // "de": "Germany",
  // "dj": "Djibouti",
  // "dk": "Denmark",
  // "dm": "Dominica",
  // "do": "Dominican Republic",
  // "dz": "Algeria",
  // "ec": "Ecuador",
  // "ee": "Estonia",
  // "eg": "Egypt",
  // "eh": "Western Sahara",
  // "er": "Eritrea",
  // "es": "Spain",
  // "et": "Ethiopia",
  // "eu": "European Union",
  // "fi": "Finland",
  // "fj": "Fiji",
  // "fk": "Falkland Islands",
  // "fm": "Micronesia",
  // "fo": "Faroe Islands",
  // "fr": "France",
  // "ga": "Gabon",
  // "gb": "United Kingdom",
  // "gb-eng": "England",
  // "gb-nir": "Northern Ireland",
  // "gb-sct": "Scotland",
  // "gb-wls": "Wales",
  // "gd": "Grenada",
  // "ge": "Georgia",
  // "gf": "French Guiana",
  // "gg": "Guernsey",
  // "gh": "Ghana",
  // "gi": "Gibraltar",
  // "gl": "Greenland",
  // "gm": "Gambia",
  // "gn": "Guinea",
  // "gp": "Guadeloupe",
  // "gq": "Equatorial Guinea",
  // "gr": "Greece",
  // "gs": "South Georgia",
  // "gt": "Guatemala",
  // "gu": "Guam",
  // "gw": "Guinea-Bissau",
  // "gy": "Guyana",
  // "hk": "Hong Kong",
  // "hm": "Heard Island and McDonald Islands",
  // "hn": "Honduras",
  // "hr": "Croatia",
  // "ht": "Haiti",
  // "hu": "Hungary",
  // "id": "Indonesia",
  // "ie": "Ireland",
  // "il": "Israel",
  // "im": "Isle of Man",
  // "in": "India",
  // "io": "British Indian Ocean Territory",
  // "iq": "Iraq",
  // "ir": "Iran",
  // "is": "Iceland",
  // "it": "Italy",
  // "je": "Jersey",
  // "jm": "Jamaica",
  // "jo": "Jordan",
  // "jp": "Japan",
  // "ke": "Kenya",
  // "kg": "Kyrgyzstan",
  // "kh": "Cambodia",
  // "ki": "Kiribati",
  // "km": "Comoros",
  // "kn": "Saint Kitts and Nevis",
  // "kp": "North Korea",
  // "kr": "South Korea",
  // "kw": "Kuwait",
  // "ky": "Cayman Islands",
  // "kz": "Kazakhstan",
  // "la": "Laos",
  // "lb": "Lebanon",
  // "lc": "Saint Lucia",
  // "li": "Liechtenstein",
  // "lk": "Sri Lanka",
  // "lr": "Liberia",
  // "ls": "Lesotho",
  // "lt": "Lithuania",
  // "lu": "Luxembourg",
  // "lv": "Latvia",
  // "ly": "Libya",
  // "ma": "Morocco",
  // "mc": "Monaco",
  // "md": "Moldova",
  // "me": "Montenegro",
  // "mf": "Saint Martin",
  // "mg": "Madagascar",
  // "mh": "Marshall Islands",
  // "mk": "North Macedonia",
  // "ml": "Mali",
  // "mm": "Myanmar",
  // "mn": "Mongolia",
  // "mo": "Macau",
  // "mp": "Northern Mariana Islands",
  // "mq": "Martinique",
  // "mr": "Mauritania",
  // "ms": "Montserrat",
  // "mt": "Malta",
  // "mu": "Mauritius",
  // "mv": "Maldives",
  // "mw": "Malawi",
  // "mx": "Mexico",
  // "my": "Malaysia",
  // "mz": "Mozambique",
  // "na": "Namibia",
  // "nc": "New Caledonia",
  // "ne": "Niger",
  // "nf": "Norfolk Island",
  // "ng": "Nigeria",
  // "ni": "Nicaragua",
  // "nl": "Netherlands",
  // "no": "Norway",
  // "np": "Nepal",
  // "nr": "Nauru",
  // "nu": "Niue",
  // "nz": "New Zealand",
  // "om": "Oman",
  // "pa": "Panama",
  // "pe": "Peru",
  // "pf": "French Polynesia",
  // "pg": "Papua New Guinea",
  // "ph": "Philippines",
  // "pk": "Pakistan",
  // "pl": "Poland",
  // "pm": "Saint Pierre and Miquelon",
  // "pn": "Pitcairn Islands",
  // "pr": "Puerto Rico",
  // "ps": "Palestine",
  // "pt": "Portugal",
  // "pw": "Palau",
  // "py": "Paraguay",
  // "qa": "Qatar",
  // "re": "Réunion",
  // "ro": "Romania",
  // "rs": "Serbia",
  // "ru": "Russia",
  // "rw": "Rwanda",
  // "sa": "Saudi Arabia",
  // "sb": "Solomon Islands",
  // "sc": "Seychelles",
  // "sd": "Sudan",
  // "se": "Sweden",
  // "sg": "Singapore",
  // "sh": "Saint Helena, Ascension and Tristan da Cunha",
  // "si": "Slovenia",
  // "sj": "Svalbard and Jan Mayen",
  // "sk": "Slovakia",
  // "sl": "Sierra Leone",
  // "sm": "San Marino",
  // "sn": "Senegal",
  // "so": "Somalia",
  // "sr": "Suriname",
  // "ss": "South Sudan",
  // "st": "São Tomé and Príncipe",
  // "sv": "El Salvador",
  // "sx": "Sint Maarten",
  // "sy": "Syria",
  // "sz": "Eswatini (Swaziland)",
  // "tc": "Turks and Caicos Islands",
  // "td": "Chad",
  // "tf": "French Southern and Antarctic Lands",
  // "tg": "Togo",
  // "th": "Thailand",
  // "tj": "Tajikistan",
  // "tk": "Tokelau",
  // "tl": "Timor-Leste",
  // "tm": "Turkmenistan",
  // "tn": "Tunisia",
  // "to": "Tonga",
  // "tr": "Turkey",
  // "tt": "Trinidad and Tobago",
  // "tv": "Tuvalu",
  // "tw": "Taiwan",
  // "tz": "Tanzania",
  // "ua": "Ukraine",
  // "ug": "Uganda",
  // "um": "United States Minor Outlying Islands",
  // "un": "United Nations",
  // "us": "United States",
  // "us-ak": "Alaska",
  // "us-al": "Alabama",
  // "us-ar": "Arkansas",
  // "us-az": "Arizona",
  // "us-ca": "California",
  // "us-co": "Colorado",
  // "us-ct": "Connecticut",
  // "us-de": "Delaware",
  // "us-fl": "Florida",
  // "us-ga": "Georgia",
  // "us-hi": "Hawaii",
  // "us-ia": "Iowa",
  // "us-id": "Idaho",
  // "us-il": "Illinois",
  // "us-in": "Indiana",
  // "us-ks": "Kansas",
  // "us-ky": "Kentucky",
  // "us-la": "Louisiana",
  // "us-ma": "Massachusetts",
  // "us-md": "Maryland",
  // "us-me": "Maine",
  // "us-mi": "Michigan",
  // "us-mn": "Minnesota",
  // "us-mo": "Missouri",
  // "us-ms": "Mississippi",
  // "us-mt": "Montana",
  // "us-nc": "North Carolina",
  // "us-nd": "North Dakota",
  // "us-ne": "Nebraska",
  // "us-nh": "New Hampshire",
  // "us-nj": "New Jersey",
  // "us-nm": "New Mexico",
  // "us-nv": "Nevada",
  // "us-ny": "New York",
  // "us-oh": "Ohio",
  // "us-ok": "Oklahoma",
  // "us-or": "Oregon",
  // "us-pa": "Pennsylvania",
  // "us-ri": "Rhode Island",
  // "us-sc": "South Carolina",
  // "us-sd": "South Dakota",
  // "us-tn": "Tennessee",
  // "us-tx": "Texas",
  // "us-ut": "Utah",
  // "us-va": "Virginia",
  // "us-vt": "Vermont",
  // "us-wa": "Washington",
  // "us-wi": "Wisconsin",
  // "us-wv": "West Virginia",
  // "us-wy": "Wyoming",
  // "uy": "Uruguay",
  // "uz": "Uzbekistan",
  // "va": "Vatican City (Holy See)",
  // "vc": "Saint Vincent and the Grenadines",
  // "ve": "Venezuela",
  // "vg": "British Virgin Islands",
  // "vi": "United States Virgin Islands",
  // "vn": "Vietnam",
  // "vu": "Vanuatu",
  // "wf": "Wallis and Futuna",
  // "ws": "Samoa",
  // "xk": "Kosovo",
  // "ye": "Yemen",
  // "yt": "Mayotte",
  // "za": "South Africa",
  // "zm": "Zambia",
  // "zw": "Zimbabwe"


// {name: 'Австралия', code: '', codeNumber:	'+61'}
// Австрия	+43
// Азербайджан	+994
// Албания	+355
// Алжир	+213
// Ангола	+244
// Андорра	+376
// Антигуа и Барбуда	+1268
// Аргентина	+54
// Армения	+374
// Афганистан	+93
// Багамы	+1242
// Бангладеш	+880
// Барбадос	+1246
// Бахрейн	+973
// Беларусь	+375
// Белиз	+501
// Бельгия	+32
// Бенин	+229
// Болгария	+359
// Боливия	+591
// Босния и Герцеговина	+387
// Ботсвана	+267
// Бразилия	+55
// Бруней	+673
// Буркина Фасо	+226
//
//
// Бурунди	+257
// Бутан	+975
// Вануату	+678
// Ватикан	+39
// Великобритания	+44
// Венгрия	+36
// Венесуэла	+58
// Восточный Тимор	+670
// Вьетнам	+84
// Габон	+241
// Гаити	+509
// Гайана	+592
// Гамбия	+220
// Гана	+233
// Гватемала	+502
// Гвинея	+224
// Гвинея-Бисау	+245
// Германия	+49
// Гондурас	+504
// Гренада	+1473
// Греция	+30
// Грузия	+995
// Дания	+45
// Джибути	+253
// Доминика	+1767
// Доминиканская Республика	+1809
// Египет	+20
// Замбия	+260
// Зимбабве	+263
// Израиль	+972
// Индия	+91
// Индонезия	+62
// Иордания	+962
// Ирак	+964
// Иран	+98
// Ирландия	+353
// Исландия	+354
// Испания	+34
// Италия	+39
// Йемен	+967
// Кабо-Верде	+238
// Казахстан	+77
// Камбоджа	+855
// Камерун	+237
// Канада	+1
// Катар	+974
// Кения	+254
// Кипр	+357
// Киргизия	+996
// Кирибати	+686
// Китай	+86
// Колумбия	+57
// Коморы	+269
// Конго, демократическая республика	+243
// Конго, республика	+242
// Коста-Рика	+506
// Кот-д’Ивуар	+225
// Куба	+53
// Кувейт	+965
// Лаос	+856
// Латвия	+371
// Лесото	+266
// Либерия	+231
// Ливан	+961
// Ливия	+218
// Литва	+370
// Лихтенштейн	+423
// Люксембург	+352
// Маврикий	+230
// Мавритания	+222
// Мадагаскар	+261
// Македония	+389
// Малави	+265
// Малайзия	+60
// Мали	+223
// Мальдивы	+960
// Мальта	+356
// Марокко	+212
// Маршалловы Острова	+692
// Мексика	+52
// Мозамбик	+259
// Молдавия	+373
// Монако	+377
// Монголия	+976
// Мьянма	+95
// Намибия	+264
// Науру	+674
// Непал	+977
// Нигер	+227
// Нигерия	+234
// Нидерланды	+31
// Никарагуа	+505
// Новая Зеландия	+64
// Норвегия	+47
// Объединенные Арабские Эмираты	+971
// Оман	+968
// Пакистан	+92
// Палау	+680
// Панама	+507
// Папуа — Новая Гвинея	+675
// Парагвай	+595
// Перу	+51
// Польша	+48
// Португалия	+351
// Россия	+7
// Руанда	+250
// Румыния	+40
// Сальвадор	+503
// Самоа	+685
// Сан-Марино	+378
// Сан-Томе и Принсипи	+239
// Саудовская Аравия	+966
// Свазиленд	+268
// Северная Корея	+850
// Сейшелы	+248
// Сенегал	+221
// Сент-Винсент и Гренадины	+1784
// Сент-Китс и Невис	+1869
// Сент-Люсия	+1758
// Сербия	+381
// Сингапур	+65
// Сирия	+963
// Словакия	+421
// Словения	+986
// Соединенные Штаты Америки	+1
// Соломоновы Острова	+677
// Сомали	+252
// Судан	+249
// Суринам	+597
// Сьерра-Леоне	+232
// Таджикистан	+992
// Таиланд	+66
// Танзания	+255
// Того	+228
// Тонга	+676
// Тринидад и Тобаго	+1868
// Тувалу	+688
// Тунис	+216
// Туркмения	+993
// Турция	+90
// Уганда	+256
// Узбекистан	+998
// Украина	+380
// Уругвай	+598
// Федеративные штаты Микронезии	+691
// Фиджи	+679
// Филиппины	+63
// Финляндия	+358
// Франция	+33
// Хорватия	+385
// Центрально-Африканская Республика	+236
// Чад	+235
// Черногория	+381
// Чехия	+420
// Чили	+56
// Швейцария	+41
// Швеция	+46
// Шри-Ланка	+94
// Эквадор	+593
// Экваториальная Гвинея	+240
// Эритрея	+291
// Эстония	+372
// Эфиопия	+251
// Южная Корея	+82
// Южно-Африканская Республика	+27
// Ямайка	+1876
// Япония	+81