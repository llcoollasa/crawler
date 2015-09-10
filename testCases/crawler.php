<?php
/*
 * @author lasantha Indrajith<hellolasantha@gmail.com>
 * @purpose testing and education purpose only
 * @Description Unit test case for CSV creation and validation
 *
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../class/csv_file.php');

$csv = new CSVFile("test.csv");

$content = array();

$content['header'][] = 'Registration Number';
$content['header'][] = 'Practising Certificate Start Date';
$content['header'][] = 'Practising Certificate End Date';
$content['header'][] = 'Qualifications';
$content['header'][] = 'Registration Date';
$content['header'][] = 'Registration Type';
$content['header'][] = 'Name of Place of Practice';
$content['header'][] = 'Address of Place of Practice';
$content['header'][] = 'Tel';
$content['header'][] = 'Map';
$content['header'][] = 'Name of Place of Practice';
$content['header'][] = 'Address of Place of Practice';
$content['header'][] = 'Tel';
$content['header'][] = 'Map';
$content['header'][] = 'Name of Place of Practice';
$content['header'][] = 'Address of Place of Practice';
$content['header'][] = 'Tel';
$content['header'][] = 'Map';

$content['data'][0] = 'E0801521J';
$content['data'][1] = '01/01/2015';
$content['data'][2] = '31/12/2016';
$content['data'][3] = 'Diploma in Optometry 2004, Singapore Polytechnic, Singapore <br/>';
$content['data'][4] = '01/01/2008';
$content['data'][5] = 'Full Registration';
$content['data'][6] = 'Singapore National Eye Centre';
$content['data'][7] = '11 THIRD HOSPITAL AVENUE Singapore 168751';
$content['data'][8] = '62277255';
$content['data'][9][0] = 'http://maps.google.com/maps?q=Singapore+168751&output=embed';
$content['data'][9][1] = 'http://www.onemap.sg/minimap/mm.html?mWidth=450&mHeight=450&searchval=168751';
$content['data'][10] = 'Eyes Palace Pte Ltd (Century Square)';
$content['data'][11] = '2 CENTURY SQUARE TAMPINES CENTRAL 5 #02 - 23 Singapore 529509';
$content['data'][12] = '';
$content['data'][13][0] = 'http://maps.google.com/maps?q=Singapore+529509&output=embed';
$content['data'][13][1] = 'http://www.onemap.sg/minimap/mm.html?mWidth=450&mHeight=450&searchval=529509';
$content['data'][14] = 'Trust Optical (828 Tampines)';
$content['data'][15] = '829 TAMPINES STREET 81 #01 - 228 Singapore 520829';
$content['data'][16] = '67830778';
$content['data'][17][0] = 'http://maps.google.com/maps?q=Singapore+520829&output=embed';
$content['data'][17][1] = 'http://www.onemap.sg/minimap/mm.html?mWidth=450&mHeight=450&searchval=520829';


print_r($content);

$csv->passData($content);

$content=null;

$content['header'][] = 'Registration Number';
$content['header'][] = 'Practising Certificate Start Date';
$content['header'][] = 'Practising Certificate End Date';
$content['header'][] = 'Qualifications';
$content['header'][] = 'Registration Date';
$content['header'][] = 'Registration Type';
$content['header'][] = 'Name of Place of Practice';
$content['header'][] = 'Address of Place of Practice';
$content['header'][] = 'Tel';
$content['header'][] = 'Map';
$content['header'][] = 'Name of Place of Practice';
$content['header'][] = 'Address of Place of Practice';
$content['header'][] = 'Tel';
$content['header'][] = 'Map';
$content['header'][] = 'Name of Place of Practice';
$content['header'][] = 'Address of Place of Practice';
$content['header'][] = 'Tel';
$content['header'][] = 'Map';
$content['header'][] = 'Map';

$content['data'][0] = '34442424224';
$content['data'][1] = '01/01/2015';
$content['data'][2] = '31/12/2016';
$content['data'][3] = 'Diploma in Optometry 2004, Singapore Polytechnic, Singapore <br/>';
$content['data'][4] = '01/01/2008';
$content['data'][5] = 'Full Registration';
$content['data'][6] = 'Singapore National Eye Centre';
$content['data'][7] = '11 THIRD HOSPITAL AVENUE Singapore 168751';
$content['data'][8] = '62277255';
$content['data'][9][0] = 'http://maps.google.com/maps?q=Singapore+168751&output=embed';
$content['data'][9][1] = 'http://www.onemap.sg/minimap/mm.html?mWidth=450&mHeight=450&searchval=168751';
$content['data'][10] = 'Eyes Palace Pte Ltd (Century Square)';
$content['data'][11] = '2 CENTURY SQUARE TAMPINES CENTRAL 5 #02 - 23 Singapore 529509';
$content['data'][12] = '';
$content['data'][13][0] = 'http://maps.google.com/maps?q=Singapore+529509&output=embed';
$content['data'][13][1] = 'http://www.onemap.sg/minimap/mm.html?mWidth=450&mHeight=450&searchval=529509';
$content['data'][14] = 'Trust Optical (828 Tampines)';
$content['data'][15] = '829 TAMPINES STREET 81 #01 - 228 Singapore 520829';
$content['data'][16] = '67830778';
$content['data'][17][0] = 'http://maps.google.com/maps?q=Singapore+520829&output=embed';
$content['data'][17][1] = 'http://www.onemap.sg/minimap/mm.html?mWidth=450&mHeight=450&searchval=520829';
$content['data'][18][0] = 'http://maps.google.com/maps?q=Singapore+520829&output=embed';
$content['data'][18][1] = 'http://www.onemap.sg/minimap/mm.html?mWidth=450&mHeight=450&searchval=520829';

echo "<hr/>";

$csv->passData($content);

print_r($csv->getData());

$csv->exportCsv();

