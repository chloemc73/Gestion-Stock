<?php
/**
 * includes/formatcurrency.php
 *
 * @package default
 * @param unknown $floatcurr
 * @param unknown $curr      (optional)
 * @return unknown
 */


function formatcurrency($floatcurr, $curr = 'XOF') {

	/**
 * Une liste des codes de devises ISO 4217 avec leur symbole, format et ordre du symbole
 *
 * Symboles provenant de :
 * http://character-code.com/currency-html-codes.php
 * http://www.phpclasses.org/browse/file/2054.html
 * https://github.com/yiisoft/yii/blob/633e54866d54bf780691baaaa4a1f847e8a07e23/framework/i18n/data/en_us.php
 *
 * Formats provenant de :
 * http://www.joelpeterson.com/blog/2011/03/formatting-over-100-currencies-in-php/
 *
 * Tableau avec comme clé le code de devise ISO 4217
 * 0 - Symbole de la devise s'il existe
 * 1 - Nombre de décimales
 * 2 - Séparateur de milliers
 * 3 - Séparateur décimal
 * 4 - 0 = symbole devant la devise ou 1 = symbole après la devise
 */
$currencies = array(
    'XOF' => array('CFA', 2, '.', ',', 0),          // Franc CFA (UEMOA)
    'XAF' => array('CFA', 0, ' ', '', 0),          // Franc CFA (CEMAC)
    'ARS' => array(NULL, 2, ',', '.', 0),          // Peso argentin
    'AMD' => array(NULL, 2, '.', ',', 0),          // Dram arménien
    'AWG' => array(NULL, 2, '.', ',', 0),          // Florin arubéen
    'AUD' => array('AU$', 2, '.', ' ', 0),          // Dollar australien
    'BSD' => array(NULL, 2, '.', ',', 0),          // Dollar bahaméen
    'BHD' => array(NULL, 3, '.', ',', 0),          // Dinar bahreïni
    'BDT' => array(NULL, 2, '.', ',', 0),          // Taka bangladais
    'BZD' => array(NULL, 2, '.', ',', 0),          // Dollar bélizien
    'BMD' => array(NULL, 2, '.', ',', 0),          // Dollar bermudien
    'BOB' => array(NULL, 2, '.', ',', 0),          // Boliviano bolivien
    'BAM' => array(NULL, 2, '.', ',', 0),          // Marks convertible de Bosnie-Herzégovine
    'BWP' => array(NULL, 2, '.', ',', 0),          // Pula botswanais
    'BRL' => array('R$', 2, ',', '.', 0),          // Réal brésilien
    'BND' => array(NULL, 2, '.', ',', 0),          // Dollar brunéien
    'CAD' => array('CA$', 2, '.', ',', 0),          // Dollar canadien
    'KYD' => array(NULL, 2, '.', ',', 0),          // Dollar des îles Caïmans
    'CLP' => array(NULL, 0, '', '.', 0),           // Peso chilien
    'CNY' => array('CN&yen;', 2, '.', ',', 0),     // Yuan chinois Renminbi
    'COP' => array(NULL, 2, ',', '.', 0),          // Peso colombien
    'CRC' => array(NULL, 2, ',', '.', 0),          // Colón costaricien
    'HRK' => array(NULL, 2, ',', '.', 0),          // Kuna croate
    'CUC' => array(NULL, 2, '.', ',', 0),          // Peso convertible cubain
    'CUP' => array(NULL, 2, '.', ',', 0),          // Peso cubain
    'CYP' => array(NULL, 2, '.', ',', 0),          // Livre chypriote
    'CZK' => array('Kc', 2, '.', ',', 1),          // Couronne tchèque
    'DKK' => array(NULL, 2, ',', '.', 0),          // Couronne danoise
    'DOP' => array(NULL, 2, '.', ',', 0),          // Peso dominicain
    'XCD' => array('EC$', 2, '.', ',', 0),         // Dollar des Caraïbes orientales
    'EGP' => array(NULL, 2, '.', ',', 0),          // Livre égyptienne
    'SVC' => array(NULL, 2, '.', ',', 0),          // Colón salvadorien
    'EUR' => array('&euro;', 2, ',', '.', 0),      // Euro
    'GHC' => array(NULL, 2, '.', ',', 0),          // Cedi ghanéen
    'GIP' => array(NULL, 2, '.', ',', 0),          // Livre de Gibraltar
    'GTQ' => array(NULL, 2, '.', ',', 0),          // Quetzal guatémaltèque
    'HNL' => array(NULL, 2, '.', ',', 0),          // Lempira hondurien
    'HKD' => array('HK$', 2, '.', ',', 0),         // Dollar hongkongais
    'HUF' => array('HK$', 0, '', '.', 0),          // Forint hongrois
    'ISK' => array('kr', 0, '', '.', 1),           // Couronne islandaise
    'INR' => array('&#2352;', 2, '.', ',', 0),     // Roupie indienne ₹
    'IDR' => array(NULL, 2, ',', '.', 0),          // Rupiah indonésien
    'IRR' => array(NULL, 2, '.', ',', 0),          // Rial iranien
    'JMD' => array(NULL, 2, '.', ',', 0),          // Dollar jamaïcain
    'JPY' => array('&yen;', 0, '', ',', 0),        // Yen japonais
    'JOD' => array(NULL, 3, '.', ',', 0),          // Dinar jordanien
    'KES' => array(NULL, 2, '.', ',', 0),          // Shilling kényan
    'KWD' => array(NULL, 3, '.', ',', 0),          // Dinar koweïtien
    'LVL' => array(NULL, 2, '.', ',', 0),          // Lats letton
    'LBP' => array(NULL, 0, '', ' ', 0),           // Livre libanaise
    'LTL' => array('Lt', 2, ',', ' ', 1),          // Litas lituanien
    'MKD' => array(NULL, 2, '.', ',', 0),          // Denar macédonien
    'MYR' => array(NULL, 2, '.', ',', 0),          // Ringgit malaisien
    'MTL' => array(NULL, 2, '.', ',', 0),          // Lira maltaise
    'MUR' => array(NULL, 0, '', ',', 0),           // Roupie mauricienne
    'MXN' => array('MX$', 2, '.', ',', 0),         // Peso mexicain
    'MZM' => array(NULL, 2, ',', '.', 0),          // Metical mozambicain
    'NPR' => array(NULL, 2, '.', ',', 0),          // Roupie népalaise
    'ANG' => array(NULL, 2, '.', ',', 0),          // Guilder antillais néerlandais
    'ILS' => array('&#8362;', 2, '.', ',', 0),     // Nouveau shekel israélien ₪
    'TRY' => array(NULL, 2, '.', ',', 0),          // Nouvelle livre turque
    'NZD' => array('NZ$', 2, '.', ',', 0),         // Dollar néo-zélandais
    'NOK' => array('kr', 2, ',', '.', 1),          // Couronne norvégienne
    'PKR' => array(NULL, 2, '.', ',', 0),          // Roupie pakistanaise
    'PEN' => array(NULL, 2, '.', ',', 0),          // Nouveau sol péruvien
    'UYU' => array(NULL, 2, ',', '.', 0),          // Peso uruguayen
    'PHP' => array(NULL, 2, '.', ',', 0),          // Peso philippin
    'PLN' => array(NULL, 2, '.', ' ', 0),          // Zloty polonais
    'GBP' => array('&pound;', 2, '.', ',', 0),     // Livre sterling
    'OMR' => array(NULL, 3, '.', ',', 0),          // Rial omanais
    'RON' => array(NULL, 2, ',', '.', 0),          // Leu roumain
    'ROL' => array(NULL, 2, ',', '.', 0),          // Ancien Leu roumain
    'RUB' => array(NULL, 2, ',', '.', 0),          // Rouble russe
    'SAR' => array(NULL, 2, '.', ',', 0),          // Riyal saoudien
    'SGD' => array(NULL, 2, '.', ',', 0),          // Dollar singapourien
    'SKK' => array(NULL, 2, ',', ' ', 0),          // Couronne slovaque
    'SIT' => array(NULL, 2, ',', '.', 0),          // Tolar slovène
    'ZAR' => array('R', 2, '.', ' ', 0),           // Rand sud-africain
    'KRW' => array('&#8361;', 0, '', ',', 0),     // Won sud-coréen ₩
    'SZL' => array(NULL, 2, '.', ', ', 0),         // Lilangeni swazi
    'SEK' => array('kr', 2, ',', '.', 1),          // Couronne suédoise
    'CHF' => array('SFr ', 2, '.', '\'', 0),       // Franc suisse
    'TZS' => array(NULL, 2, '.', ',', 0),          // Shilling tanzanien
    'THB' => array('&#3647;', 2, '.', ',', 1),     // Baht thaïlandais ฿
    'TOP' => array(NULL, 2, '.', ',', 0),          // Pa'anga tongien
    'AED' => array(NULL, 2, '.', ',', 0),          // Dirham des Émirats arabes unis
    'UAH' => array(NULL, 2, ',', ' ', 0),          // Hryvnia ukrainienne
    'USD' => array('$', 2, '.', ',', 0),           // Dollar américain
    'VUV' => array(NULL, 0, '', ',', 0),           // Vatu vanuatais
    'VEF' => array(NULL, 2, ',', '.', 0),          // Bolivar vénézuélien (ancien)
    'VEB' => array(NULL, 2, ',', '.', 0),          // Bolivar vénézuélien
    'VND' => array('&#x20ab;', 0, '', '.', 0),     // Đồng vietnamien ₫
    'ZWD' => array(NULL, 2, '.', ' ', 0),          // Dollar zimbabwéen
    
);


	// Format spécial pour la roupie
if ($curr == "INR")
$number = formatinr($floatcurr);  // Si c'est la roupie indienne, applique la fonction de formatage 
// spécifique
else
$number = number_format($floatcurr, $currencies[$curr][1], $currencies[$curr][2], $currencies[$curr][3]);  
// Sinon, utilise le format général pour la devise

// Ajout du symbole à la fin
if ($currencies[$curr][0] === NULL)
$number .= ' ' . $curr;  // Si aucun symbole n'est défini pour la devise, ajoute la devise après
//  le montant
elseif ($currencies[$curr][4] === 1)
$number .= $currencies[$curr][0];  // Si la devise place le symbole à la fin, ajoute le symbole à
//  la fin
else
$number = $currencies[$curr][0] . $number;  // Sinon, le symbole est ajouté avant le montant

return $number;  // Retourne le montant formaté avec le symbole

/**
* Formate les montants en roupies indiennes (INR)
* Source : http://www.joelpeterson.com/blog/2011/03/formatting-over-100-currencies-in-php/
*
* @param float   $input Montant à formater
* @return string        Montant formaté selon les règles des roupies indiennes
*/
function formatinr($input) {
// Fonction personnalisée pour générer le format ##,##,###.##
$dec = "";
$pos = strpos($input, ".");
if ($pos === false) {
	// Pas de décimales
} else {
	// Si il y a des décimales
	$dec = substr(round(substr($input, $pos), 2), 1);  // Récupère les décimales (2 chiffres après 
    // la virgule)
	$input = substr($input, 0, $pos);  // Supprime la partie décimale pour le formatage
}

$num = substr($input, -3);  // Récupère les 3 derniers chiffres
$input = substr($input, 0, -3);  // Omet les 3 derniers chiffres déjà récupérés dans $num

while (strlen($input) > 0) {  // Boucle pour traiter les chiffres par groupes de 2
	$num = substr($input, -2) . "," . $num;  // Ajoute une virgule tous les deux chiffres
	$input = substr($input, 0, -2);  // Supprime les 2 derniers chiffres
}

return $num . $dec;  // Retourne le montant formaté avec les décimales
}

    echo '<br>'.formatcurrency(1000000, "XOF");         // CFA 1 000 000
    echo '<br>'.formatcurrency(250000, "XAF");          // CFA 250 000
    echo '<br>'.formatcurrency(39174.00000000001);             //1,000,045.25 (USD)
    echo '<br>'.formatcurrency(1000045.25, "CHF");        //1'000'045.25
    echo '<br>'.formatcurrency(1000045.25, "EUR");      //1.000.045,25
    echo '<br>'.formatcurrency(1000045, "JPY");         //1,000,045
    echo '<br>'.formatcurrency(1000045, "VND");         //1 000 045
    echo '<br>'.formatcurrency(1000045.25, "INR");      //10,00,045.25
    echo '<br>'.formatcurrency(1000045.25, "ILS");      //10,00,045.25
    echo '<br>'.formatcurrency(1000045.25, "THB");      //10,00,045.25
    echo '<br>'.formatcurrency(1000045.25, "KRW");      //10,00,045.25
   

}
