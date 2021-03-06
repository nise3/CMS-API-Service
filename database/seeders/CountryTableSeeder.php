<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('countries')->truncate();

        $countries = [
            array('id' => '1', 'title' => 'Afghanistan', 'title_en' => 'Afghanistan', 'code' => 'AF', 'deleted_at' => NULL),
            array('id' => '2', 'title' => 'Åland Islands', 'title_en' => 'Åland Islands', 'code' => 'AX', 'deleted_at' => NULL),
            array('id' => '3', 'title' => 'Albania', 'title_en' => 'Albania', 'code' => 'AL', 'deleted_at' => NULL),
            array('id' => '4', 'title' => 'Algeria', 'title_en' => 'Algeria', 'code' => 'DZ', 'deleted_at' => NULL),
            array('id' => '5', 'title' => 'American Samoa', 'title_en' => 'American Samoa', 'code' => 'AS', 'deleted_at' => NULL),
            array('id' => '6', 'title' => 'Andorra', 'title_en' => 'Andorra', 'code' => 'AD', 'deleted_at' => NULL),
            array('id' => '7', 'title' => 'Angola', 'title_en' => 'Angola', 'code' => 'AO', 'deleted_at' => NULL),
            array('id' => '8', 'title' => 'Anguilla', 'title_en' => 'Anguilla', 'code' => 'AI', 'deleted_at' => NULL),
            array('id' => '9', 'title' => 'Antarctica', 'title_en' => 'Antarctica', 'code' => 'AQ', 'deleted_at' => NULL),
            array('id' => '10', 'title' => 'Antigua and Barbuda', 'title_en' => 'Antigua and Barbuda', 'code' => 'AG', 'deleted_at' => NULL),
            array('id' => '11', 'title' => 'Argentina', 'title_en' => 'Argentina', 'code' => 'AR', 'deleted_at' => NULL),
            array('id' => '12', 'title' => 'Armenia', 'title_en' => 'Armenia', 'code' => 'AM', 'deleted_at' => NULL),
            array('id' => '13', 'title' => 'Aruba', 'title_en' => 'Aruba', 'code' => 'AW', 'deleted_at' => NULL),
            array('id' => '14', 'title' => 'Australia', 'title_en' => 'Australia', 'code' => 'AU', 'deleted_at' => NULL),
            array('id' => '15', 'title' => 'Austria', 'title_en' => 'Austria', 'code' => 'AT', 'deleted_at' => NULL),
            array('id' => '16', 'title' => 'Azerbaijan', 'title_en' => 'Azerbaijan', 'code' => 'AZ', 'deleted_at' => NULL),
            array('id' => '17', 'title' => 'Bahamas', 'title_en' => 'Bahamas', 'code' => 'BS', 'deleted_at' => NULL),
            array('id' => '18', 'title' => 'Bahrain', 'title_en' => 'Bahrain', 'code' => 'BH', 'deleted_at' => NULL),
            array('id' => '19', 'title' => 'Bangladesh', 'title_en' => 'Bangladesh', 'code' => 'BD', 'deleted_at' => NULL),
            array('id' => '20', 'title' => 'Barbados', 'title_en' => 'Barbados', 'code' => 'BB', 'deleted_at' => NULL),
            array('id' => '21', 'title' => 'Belarus', 'title_en' => 'Belarus', 'code' => 'BY', 'deleted_at' => NULL),
            array('id' => '22', 'title' => 'Belgium', 'title_en' => 'Belgium', 'code' => 'BE', 'deleted_at' => NULL),
            array('id' => '23', 'title' => 'Belize', 'title_en' => 'Belize', 'code' => 'BZ', 'deleted_at' => NULL),
            array('id' => '24', 'title' => 'Benin', 'title_en' => 'Benin', 'code' => 'BJ', 'deleted_at' => NULL),
            array('id' => '25', 'title' => 'Bermuda', 'title_en' => 'Bermuda', 'code' => 'BM', 'deleted_at' => NULL),
            array('id' => '26', 'title' => 'Bhutan', 'title_en' => 'Bhutan', 'code' => 'BT', 'deleted_at' => NULL),
            array('id' => '27', 'title' => 'Bolivia, Plurinational State of', 'title_en' => 'Bolivia, Plurinational State of', 'code' => 'BO', 'deleted_at' => NULL),
            array('id' => '28', 'title' => 'Bonaire, Sint Eustatius and Saba', 'title_en' => 'Bonaire, Sint Eustatius and Saba', 'code' => 'BQ', 'deleted_at' => NULL),
            array('id' => '29', 'title' => 'Bosnia and Herzegovina', 'title_en' => 'Bosnia and Herzegovina', 'code' => 'BA', 'deleted_at' => NULL),
            array('id' => '30', 'title' => 'Botswana', 'title_en' => 'Botswana', 'code' => 'BW', 'deleted_at' => NULL),
            array('id' => '31', 'title' => 'Bouvet Island', 'title_en' => 'Bouvet Island', 'code' => 'BV', 'deleted_at' => NULL),
            array('id' => '32', 'title' => 'Brazil', 'title_en' => 'Brazil', 'code' => 'BR', 'deleted_at' => NULL),
            array('id' => '33', 'title' => 'British Indian Ocean Territory', 'title_en' => 'British Indian Ocean Territory', 'code' => 'IO', 'deleted_at' => NULL),
            array('id' => '34', 'title' => 'Brunei Darussalam', 'title_en' => 'Brunei Darussalam', 'code' => 'BN', 'deleted_at' => NULL),
            array('id' => '35', 'title' => 'Bulgaria', 'title_en' => 'Bulgaria', 'code' => 'BG', 'deleted_at' => NULL),
            array('id' => '36', 'title' => 'Burkina Faso', 'title_en' => 'Burkina Faso', 'code' => 'BF', 'deleted_at' => NULL),
            array('id' => '37', 'title' => 'Burundi', 'title_en' => 'Burundi', 'code' => 'BI', 'deleted_at' => NULL),
            array('id' => '38', 'title' => 'Cambodia', 'title_en' => 'Cambodia', 'code' => 'KH', 'deleted_at' => NULL),
            array('id' => '39', 'title' => 'Cameroon', 'title_en' => 'Cameroon', 'code' => 'CM', 'deleted_at' => NULL),
            array('id' => '40', 'title' => 'Canada', 'title_en' => 'Canada', 'code' => 'CA', 'deleted_at' => NULL),
            array('id' => '41', 'title' => 'Cape Verde', 'title_en' => 'Cape Verde', 'code' => 'CV', 'deleted_at' => NULL),
            array('id' => '42', 'title' => 'Cayman Islands', 'title_en' => 'Cayman Islands', 'code' => 'KY', 'deleted_at' => NULL),
            array('id' => '43', 'title' => 'Central African Republic', 'title_en' => 'Central African Republic', 'code' => 'CF', 'deleted_at' => NULL),
            array('id' => '44', 'title' => 'Chad', 'title_en' => 'Chad', 'code' => 'TD', 'deleted_at' => NULL),
            array('id' => '45', 'title' => 'Chile', 'title_en' => 'Chile', 'code' => 'CL', 'deleted_at' => NULL),
            array('id' => '46', 'title' => 'China', 'title_en' => 'China', 'code' => 'CN', 'deleted_at' => NULL),
            array('id' => '47', 'title' => 'Christmas Island', 'title_en' => 'Christmas Island', 'code' => 'CX', 'deleted_at' => NULL),
            array('id' => '48', 'title' => 'Cocos (Keeling) Islands', 'title_en' => 'Cocos (Keeling) Islands', 'code' => 'CC', 'deleted_at' => NULL),
            array('id' => '49', 'title' => 'Colombia', 'title_en' => 'Colombia', 'code' => 'CO', 'deleted_at' => NULL),
            array('id' => '50', 'title' => 'Comoros', 'title_en' => 'Comoros', 'code' => 'KM', 'deleted_at' => NULL),
            array('id' => '51', 'title' => 'Congo', 'title_en' => 'Congo', 'code' => 'CG', 'deleted_at' => NULL),
            array('id' => '52', 'title' => 'Congo, the Democratic Republic of the', 'title_en' => 'Congo, the Democratic Republic of the', 'code' => 'CD', 'deleted_at' => NULL),
            array('id' => '53', 'title' => 'Cook Islands', 'title_en' => 'Cook Islands', 'code' => 'CK', 'deleted_at' => NULL),
            array('id' => '54', 'title' => 'Costa Rica', 'title_en' => 'Costa Rica', 'code' => 'CR', 'deleted_at' => NULL),
            array('id' => '55', 'title' => 'Côte d\'Ivoire', 'title_en' => 'Côte d\'Ivoire', 'code' => 'CI', 'deleted_at' => NULL),
            array('id' => '56', 'title' => 'Croatia', 'title_en' => 'Croatia', 'code' => 'HR', 'deleted_at' => NULL),
            array('id' => '57', 'title' => 'Cuba', 'title_en' => 'Cuba', 'code' => 'CU', 'deleted_at' => NULL),
            array('id' => '58', 'title' => 'Curaçao', 'title_en' => 'Curaçao', 'code' => 'CW', 'deleted_at' => NULL),
            array('id' => '59', 'title' => 'Cyprus', 'title_en' => 'Cyprus', 'code' => 'CY', 'deleted_at' => NULL),
            array('id' => '60', 'title' => 'Czech Republic', 'title_en' => 'Czech Republic', 'code' => 'CZ', 'deleted_at' => NULL),
            array('id' => '61', 'title' => 'Denmark', 'title_en' => 'Denmark', 'code' => 'DK', 'deleted_at' => NULL),
            array('id' => '62', 'title' => 'Djibouti', 'title_en' => 'Djibouti', 'code' => 'DJ', 'deleted_at' => NULL),
            array('id' => '63', 'title' => 'Dominica', 'title_en' => 'Dominica', 'code' => 'DM', 'deleted_at' => NULL),
            array('id' => '64', 'title' => 'Dominican Republic', 'title_en' => 'Dominican Republic', 'code' => 'DO', 'deleted_at' => NULL),
            array('id' => '65', 'title' => 'Ecuador', 'title_en' => 'Ecuador', 'code' => 'EC', 'deleted_at' => NULL),
            array('id' => '66', 'title' => 'Egypt', 'title_en' => 'Egypt', 'code' => 'EG', 'deleted_at' => NULL),
            array('id' => '67', 'title' => 'El Salvador', 'title_en' => 'El Salvador', 'code' => 'SV', 'deleted_at' => NULL),
            array('id' => '68', 'title' => 'Equatorial Guinea', 'title_en' => 'Equatorial Guinea', 'code' => 'GQ', 'deleted_at' => NULL),
            array('id' => '69', 'title' => 'Eritrea', 'title_en' => 'Eritrea', 'code' => 'ER', 'deleted_at' => NULL),
            array('id' => '70', 'title' => 'Estonia', 'title_en' => 'Estonia', 'code' => 'EE', 'deleted_at' => NULL),
            array('id' => '71', 'title' => 'Ethiopia', 'title_en' => 'Ethiopia', 'code' => 'ET', 'deleted_at' => NULL),
            array('id' => '72', 'title' => 'Falkland Islands (Malvinas)', 'title_en' => 'Falkland Islands (Malvinas)', 'code' => 'FK', 'deleted_at' => NULL),
            array('id' => '73', 'title' => 'Faroe Islands', 'title_en' => 'Faroe Islands', 'code' => 'FO', 'deleted_at' => NULL),
            array('id' => '74', 'title' => 'Fiji', 'title_en' => 'Fiji', 'code' => 'FJ', 'deleted_at' => NULL),
            array('id' => '75', 'title' => 'Finland', 'title_en' => 'Finland', 'code' => 'FI', 'deleted_at' => NULL),
            array('id' => '76', 'title' => 'France', 'title_en' => 'France', 'code' => 'FR', 'deleted_at' => NULL),
            array('id' => '77', 'title' => 'French Guiana', 'title_en' => 'French Guiana', 'code' => 'GF', 'deleted_at' => NULL),
            array('id' => '78', 'title' => 'French Polynesia', 'title_en' => 'French Polynesia', 'code' => 'PF', 'deleted_at' => NULL),
            array('id' => '79', 'title' => 'French Southern Territories', 'title_en' => 'French Southern Territories', 'code' => 'TF', 'deleted_at' => NULL),
            array('id' => '80', 'title' => 'Gabon', 'title_en' => 'Gabon', 'code' => 'GA', 'deleted_at' => NULL),
            array('id' => '81', 'title' => 'Gambia', 'title_en' => 'Gambia', 'code' => 'GM', 'deleted_at' => NULL),
            array('id' => '82', 'title' => 'Georgia', 'title_en' => 'Georgia', 'code' => 'GE', 'deleted_at' => NULL),
            array('id' => '83', 'title' => 'Germany', 'title_en' => 'Germany', 'code' => 'DE', 'deleted_at' => NULL),
            array('id' => '84', 'title' => 'Ghana', 'title_en' => 'Ghana', 'code' => 'GH', 'deleted_at' => NULL),
            array('id' => '85', 'title' => 'Gibraltar', 'title_en' => 'Gibraltar', 'code' => 'GI', 'deleted_at' => NULL),
            array('id' => '86', 'title' => 'Greece', 'title_en' => 'Greece', 'code' => 'GR', 'deleted_at' => NULL),
            array('id' => '87', 'title' => 'Greenland', 'title_en' => 'Greenland', 'code' => 'GL', 'deleted_at' => NULL),
            array('id' => '88', 'title' => 'Grenada', 'title_en' => 'Grenada', 'code' => 'GD', 'deleted_at' => NULL),
            array('id' => '89', 'title' => 'Guadeloupe', 'title_en' => 'Guadeloupe', 'code' => 'GP', 'deleted_at' => NULL),
            array('id' => '90', 'title' => 'Guam', 'title_en' => 'Guam', 'code' => 'GU', 'deleted_at' => NULL),
            array('id' => '91', 'title' => 'Guatemala', 'title_en' => 'Guatemala', 'code' => 'GT', 'deleted_at' => NULL),
            array('id' => '92', 'title' => 'Guernsey', 'title_en' => 'Guernsey', 'code' => 'GG', 'deleted_at' => NULL),
            array('id' => '93', 'title' => 'Guinea', 'title_en' => 'Guinea', 'code' => 'GN', 'deleted_at' => NULL),
            array('id' => '94', 'title' => 'Guinea-Bissau', 'title_en' => 'Guinea-Bissau', 'code' => 'GW', 'deleted_at' => NULL),
            array('id' => '95', 'title' => 'Guyana', 'title_en' => 'Guyana', 'code' => 'GY', 'deleted_at' => NULL),
            array('id' => '96', 'title' => 'Haiti', 'title_en' => 'Haiti', 'code' => 'HT', 'deleted_at' => NULL),
            array('id' => '97', 'title' => 'Heard Island and McDonald Mcdonald Islands', 'title_en' => 'Heard Island and McDonald Mcdonald Islands', 'code' => 'HM', 'deleted_at' => NULL),
            array('id' => '98', 'title' => 'Holy See (Vatican City State)', 'title_en' => 'Holy See (Vatican City State)', 'code' => 'VA', 'deleted_at' => NULL),
            array('id' => '99', 'title' => 'Honduras', 'title_en' => 'Honduras', 'code' => 'HN', 'deleted_at' => NULL),
            array('id' => '100', 'title' => 'Hong Kong', 'title_en' => 'Hong Kong', 'code' => 'HK', 'deleted_at' => NULL),
            array('id' => '101', 'title' => 'Hungary', 'title_en' => 'Hungary', 'code' => 'HU', 'deleted_at' => NULL),
            array('id' => '102', 'title' => 'Iceland', 'title_en' => 'Iceland', 'code' => 'IS', 'deleted_at' => NULL),
            array('id' => '103', 'title' => 'India', 'title_en' => 'India', 'code' => 'IN', 'deleted_at' => NULL),
            array('id' => '104', 'title' => 'Indonesia', 'title_en' => 'Indonesia', 'code' => 'ID', 'deleted_at' => NULL),
            array('id' => '105', 'title' => 'Iran, Islamic Republic of', 'title_en' => 'Iran, Islamic Republic of', 'code' => 'IR', 'deleted_at' => NULL),
            array('id' => '106', 'title' => 'Iraq', 'title_en' => 'Iraq', 'code' => 'IQ', 'deleted_at' => NULL),
            array('id' => '107', 'title' => 'Ireland', 'title_en' => 'Ireland', 'code' => 'IE', 'deleted_at' => NULL),
            array('id' => '108', 'title' => 'Isle of Man', 'title_en' => 'Isle of Man', 'code' => 'IM', 'deleted_at' => NULL),
            array('id' => '109', 'title' => 'Israel', 'title_en' => 'Israel', 'code' => 'IL', 'deleted_at' => NULL),
            array('id' => '110', 'title' => 'Italy', 'title_en' => 'Italy', 'code' => 'IT', 'deleted_at' => NULL),
            array('id' => '111', 'title' => 'Jamaica', 'title_en' => 'Jamaica', 'code' => 'JM', 'deleted_at' => NULL),
            array('id' => '112', 'title' => 'Japan', 'title_en' => 'Japan', 'code' => 'JP', 'deleted_at' => NULL),
            array('id' => '113', 'title' => 'Jersey', 'title_en' => 'Jersey', 'code' => 'JE', 'deleted_at' => NULL),
            array('id' => '114', 'title' => 'Jordan', 'title_en' => 'Jordan', 'code' => 'JO', 'deleted_at' => NULL),
            array('id' => '115', 'title' => 'Kazakhstan', 'title_en' => 'Kazakhstan', 'code' => 'KZ', 'deleted_at' => NULL),
            array('id' => '116', 'title' => 'Kenya', 'title_en' => 'Kenya', 'code' => 'KE', 'deleted_at' => NULL),
            array('id' => '117', 'title' => 'Kiribati', 'title_en' => 'Kiribati', 'code' => 'KI', 'deleted_at' => NULL),
            array('id' => '118', 'title' => 'Korea, Democratic People\'s Republic of', 'title_en' => 'Korea, Democratic People\'s Republic of', 'code' => 'KP', 'deleted_at' => NULL),
            array('id' => '119', 'title' => 'Korea, Republic of', 'title_en' => 'Korea, Republic of', 'code' => 'KR', 'deleted_at' => NULL),
            array('id' => '120', 'title' => 'Kuwait', 'title_en' => 'Kuwait', 'code' => 'KW', 'deleted_at' => NULL),
            array('id' => '121', 'title' => 'Kyrgyzstan', 'title_en' => 'Kyrgyzstan', 'code' => 'KG', 'deleted_at' => NULL),
            array('id' => '122', 'title' => 'Lao People\'s Democratic Republic', 'title_en' => 'Lao People\'s Democratic Republic', 'code' => 'LA', 'deleted_at' => NULL),
            array('id' => '123', 'title' => 'Latvia', 'title_en' => 'Latvia', 'code' => 'LV', 'deleted_at' => NULL),
            array('id' => '124', 'title' => 'Lebanon', 'title_en' => 'Lebanon', 'code' => 'LB', 'deleted_at' => NULL),
            array('id' => '125', 'title' => 'Lesotho', 'title_en' => 'Lesotho', 'code' => 'LS', 'deleted_at' => NULL),
            array('id' => '126', 'title' => 'Liberia', 'title_en' => 'Liberia', 'code' => 'LR', 'deleted_at' => NULL),
            array('id' => '127', 'title' => 'Libya', 'title_en' => 'Libya', 'code' => 'LY', 'deleted_at' => NULL),
            array('id' => '128', 'title' => 'Liechtenstein', 'title_en' => 'Liechtenstein', 'code' => 'LI', 'deleted_at' => NULL),
            array('id' => '129', 'title' => 'Lithuania', 'title_en' => 'Lithuania', 'code' => 'LT', 'deleted_at' => NULL),
            array('id' => '130', 'title' => 'Luxembourg', 'title_en' => 'Luxembourg', 'code' => 'LU', 'deleted_at' => NULL),
            array('id' => '131', 'title' => 'Macao', 'title_en' => 'Macao', 'code' => 'MO', 'deleted_at' => NULL),
            array('id' => '132', 'title' => 'Macedonia, the Former Yugoslav Republic of', 'title_en' => 'Macedonia, the Former Yugoslav Republic of', 'code' => 'MK', 'deleted_at' => NULL),
            array('id' => '133', 'title' => 'Madagascar', 'title_en' => 'Madagascar', 'code' => 'MG', 'deleted_at' => NULL),
            array('id' => '134', 'title' => 'Malawi', 'title_en' => 'Malawi', 'code' => 'MW', 'deleted_at' => NULL),
            array('id' => '135', 'title' => 'Malaysia', 'title_en' => 'Malaysia', 'code' => 'MY', 'deleted_at' => NULL),
            array('id' => '136', 'title' => 'Maldives', 'title_en' => 'Maldives', 'code' => 'MV', 'deleted_at' => NULL),
            array('id' => '137', 'title' => 'Mali', 'title_en' => 'Mali', 'code' => 'ML', 'deleted_at' => NULL),
            array('id' => '138', 'title' => 'Malta', 'title_en' => 'Malta', 'code' => 'MT', 'deleted_at' => NULL),
            array('id' => '139', 'title' => 'Marshall Islands', 'title_en' => 'Marshall Islands', 'code' => 'MH', 'deleted_at' => NULL),
            array('id' => '140', 'title' => 'Martinique', 'title_en' => 'Martinique', 'code' => 'MQ', 'deleted_at' => NULL),
            array('id' => '141', 'title' => 'Mauritania', 'title_en' => 'Mauritania', 'code' => 'MR', 'deleted_at' => NULL),
            array('id' => '142', 'title' => 'Mauritius', 'title_en' => 'Mauritius', 'code' => 'MU', 'deleted_at' => NULL),
            array('id' => '143', 'title' => 'Mayotte', 'title_en' => 'Mayotte', 'code' => 'YT', 'deleted_at' => NULL),
            array('id' => '144', 'title' => 'Mexico', 'title_en' => 'Mexico', 'code' => 'MX', 'deleted_at' => NULL),
            array('id' => '145', 'title' => 'Micronesia, Federated States of', 'title_en' => 'Micronesia, Federated States of', 'code' => 'FM', 'deleted_at' => NULL),
            array('id' => '146', 'title' => 'Moldova, Republic of', 'title_en' => 'Moldova, Republic of', 'code' => 'MD', 'deleted_at' => NULL),
            array('id' => '147', 'title' => 'Monaco', 'title_en' => 'Monaco', 'code' => 'MC', 'deleted_at' => NULL),
            array('id' => '148', 'title' => 'Mongolia', 'title_en' => 'Mongolia', 'code' => 'MN', 'deleted_at' => NULL),
            array('id' => '149', 'title' => 'Montenegro', 'title_en' => 'Montenegro', 'code' => 'ME', 'deleted_at' => NULL),
            array('id' => '150', 'title' => 'Montserrat', 'title_en' => 'Montserrat', 'code' => 'MS', 'deleted_at' => NULL),
            array('id' => '151', 'title' => 'Morocco', 'title_en' => 'Morocco', 'code' => 'MA', 'deleted_at' => NULL),
            array('id' => '152', 'title' => 'Mozambique', 'title_en' => 'Mozambique', 'code' => 'MZ', 'deleted_at' => NULL),
            array('id' => '153', 'title' => 'Myanmar', 'title_en' => 'Myanmar', 'code' => 'MM', 'deleted_at' => NULL),
            array('id' => '154', 'title' => 'Namibia', 'title_en' => 'Namibia', 'code' => 'NA', 'deleted_at' => NULL),
            array('id' => '155', 'title' => 'Nauru', 'title_en' => 'Nauru', 'code' => 'NR', 'deleted_at' => NULL),
            array('id' => '156', 'title' => 'Nepal', 'title_en' => 'Nepal', 'code' => 'NP', 'deleted_at' => NULL),
            array('id' => '157', 'title' => 'Netherlands', 'title_en' => 'Netherlands', 'code' => 'NL', 'deleted_at' => NULL),
            array('id' => '158', 'title' => 'New Caledonia', 'title_en' => 'New Caledonia', 'code' => 'NC', 'deleted_at' => NULL),
            array('id' => '159', 'title' => 'New Zealand', 'title_en' => 'New Zealand', 'code' => 'NZ', 'deleted_at' => NULL),
            array('id' => '160', 'title' => 'Nicaragua', 'title_en' => 'Nicaragua', 'code' => 'NI', 'deleted_at' => NULL),
            array('id' => '161', 'title' => 'Niger', 'title_en' => 'Niger', 'code' => 'NE', 'deleted_at' => NULL),
            array('id' => '162', 'title' => 'Nigeria', 'title_en' => 'Nigeria', 'code' => 'NG', 'deleted_at' => NULL),
            array('id' => '163', 'title' => 'Niue', 'title_en' => 'Niue', 'code' => 'NU', 'deleted_at' => NULL),
            array('id' => '164', 'title' => 'Norfolk Island', 'title_en' => 'Norfolk Island', 'code' => 'NF', 'deleted_at' => NULL),
            array('id' => '165', 'title' => 'Northern Mariana Islands', 'title_en' => 'Northern Mariana Islands', 'code' => 'MP', 'deleted_at' => NULL),
            array('id' => '166', 'title' => 'Norway', 'title_en' => 'Norway', 'code' => 'NO', 'deleted_at' => NULL),
            array('id' => '167', 'title' => 'Oman', 'title_en' => 'Oman', 'code' => 'OM', 'deleted_at' => NULL),
            array('id' => '168', 'title' => 'Pakistan', 'title_en' => 'Pakistan', 'code' => 'PK', 'deleted_at' => NULL),
            array('id' => '169', 'title' => 'Palau', 'title_en' => 'Palau', 'code' => 'PW', 'deleted_at' => NULL),
            array('id' => '170', 'title' => 'Palestine, State of', 'title_en' => 'Palestine, State of', 'code' => 'PS', 'deleted_at' => NULL),
            array('id' => '171', 'title' => 'Panama', 'title_en' => 'Panama', 'code' => 'PA', 'deleted_at' => NULL),
            array('id' => '172', 'title' => 'Papua New Guinea', 'title_en' => 'Papua New Guinea', 'code' => 'PG', 'deleted_at' => NULL),
            array('id' => '173', 'title' => 'Paraguay', 'title_en' => 'Paraguay', 'code' => 'PY', 'deleted_at' => NULL),
            array('id' => '174', 'title' => 'Peru', 'title_en' => 'Peru', 'code' => 'PE', 'deleted_at' => NULL),
            array('id' => '175', 'title' => 'Philippines', 'title_en' => 'Philippines', 'code' => 'PH', 'deleted_at' => NULL),
            array('id' => '176', 'title' => 'Pitcairn', 'title_en' => 'Pitcairn', 'code' => 'PN', 'deleted_at' => NULL),
            array('id' => '177', 'title' => 'Poland', 'title_en' => 'Poland', 'code' => 'PL', 'deleted_at' => NULL),
            array('id' => '178', 'title' => 'Portugal', 'title_en' => 'Portugal', 'code' => 'PT', 'deleted_at' => NULL),
            array('id' => '179', 'title' => 'Puerto Rico', 'title_en' => 'Puerto Rico', 'code' => 'PR', 'deleted_at' => NULL),
            array('id' => '180', 'title' => 'Qatar', 'title_en' => 'Qatar', 'code' => 'QA', 'deleted_at' => NULL),
            array('id' => '181', 'title' => 'Réunion', 'title_en' => 'Réunion', 'code' => 'RE', 'deleted_at' => NULL),
            array('id' => '182', 'title' => 'Romania', 'title_en' => 'Romania', 'code' => 'RO', 'deleted_at' => NULL),
            array('id' => '183', 'title' => 'Russian Federation', 'title_en' => 'Russian Federation', 'code' => 'RU', 'deleted_at' => NULL),
            array('id' => '184', 'title' => 'Rwanda', 'title_en' => 'Rwanda', 'code' => 'RW', 'deleted_at' => NULL),
            array('id' => '185', 'title' => 'Saint Barthélemy', 'title_en' => 'Saint Barthélemy', 'code' => 'BL', 'deleted_at' => NULL),
            array('id' => '186', 'title' => 'Saint Helena, Ascension and Tristan da Cunha', 'title_en' => 'Saint Helena, Ascension and Tristan da Cunha', 'code' => 'SH', 'deleted_at' => NULL),
            array('id' => '187', 'title' => 'Saint Kitts and Nevis', 'title_en' => 'Saint Kitts and Nevis', 'code' => 'KN', 'deleted_at' => NULL),
            array('id' => '188', 'title' => 'Saint Lucia', 'title_en' => 'Saint Lucia', 'code' => 'LC', 'deleted_at' => NULL),
            array('id' => '189', 'title' => 'Saint Martin (French part)', 'title_en' => 'Saint Martin (French part)', 'code' => 'MF', 'deleted_at' => NULL),
            array('id' => '190', 'title' => 'Saint Pierre and Miquelon', 'title_en' => 'Saint Pierre and Miquelon', 'code' => 'PM', 'deleted_at' => NULL),
            array('id' => '191', 'title' => 'Saint Vincent and the Grenadines', 'title_en' => 'Saint Vincent and the Grenadines', 'code' => 'VC', 'deleted_at' => NULL),
            array('id' => '192', 'title' => 'Samoa', 'title_en' => 'Samoa', 'code' => 'WS', 'deleted_at' => NULL),
            array('id' => '193', 'title' => 'San Marino', 'title_en' => 'San Marino', 'code' => 'SM', 'deleted_at' => NULL),
            array('id' => '194', 'title' => 'Sao Tome and Principe', 'title_en' => 'Sao Tome and Principe', 'code' => 'ST', 'deleted_at' => NULL),
            array('id' => '195', 'title' => 'Saudi Arabia', 'title_en' => 'Saudi Arabia', 'code' => 'SA', 'deleted_at' => NULL),
            array('id' => '196', 'title' => 'Senegal', 'title_en' => 'Senegal', 'code' => 'SN', 'deleted_at' => NULL),
            array('id' => '197', 'title' => 'Serbia', 'title_en' => 'Serbia', 'code' => 'RS', 'deleted_at' => NULL),
            array('id' => '198', 'title' => 'Seychelles', 'title_en' => 'Seychelles', 'code' => 'SC', 'deleted_at' => NULL),
            array('id' => '199', 'title' => 'Sierra Leone', 'title_en' => 'Sierra Leone', 'code' => 'SL', 'deleted_at' => NULL),
            array('id' => '200', 'title' => 'Singapore', 'title_en' => 'Singapore', 'code' => 'SG', 'deleted_at' => NULL),
            array('id' => '201', 'title' => 'Sint Maarten (Dutch part)', 'title_en' => 'Sint Maarten (Dutch part)', 'code' => 'SX', 'deleted_at' => NULL),
            array('id' => '202', 'title' => 'Slovakia', 'title_en' => 'Slovakia', 'code' => 'SK', 'deleted_at' => NULL),
            array('id' => '203', 'title' => 'Slovenia', 'title_en' => 'Slovenia', 'code' => 'SI', 'deleted_at' => NULL),
            array('id' => '204', 'title' => 'Solomon Islands', 'title_en' => 'Solomon Islands', 'code' => 'SB', 'deleted_at' => NULL),
            array('id' => '205', 'title' => 'Somalia', 'title_en' => 'Somalia', 'code' => 'SO', 'deleted_at' => NULL),
            array('id' => '206', 'title' => 'South Africa', 'title_en' => 'South Africa', 'code' => 'ZA', 'deleted_at' => NULL),
            array('id' => '207', 'title' => 'South Georgia and the South Sandwich Islands', 'title_en' => 'South Georgia and the South Sandwich Islands', 'code' => 'GS', 'deleted_at' => NULL),
            array('id' => '208', 'title' => 'South Sudan', 'title_en' => 'South Sudan', 'code' => 'SS', 'deleted_at' => NULL),
            array('id' => '209', 'title' => 'Spain', 'title_en' => 'Spain', 'code' => 'ES', 'deleted_at' => NULL),
            array('id' => '210', 'title' => 'Sri Lanka', 'title_en' => 'Sri Lanka', 'code' => 'LK', 'deleted_at' => NULL),
            array('id' => '211', 'title' => 'Sudan', 'title_en' => 'Sudan', 'code' => 'SD', 'deleted_at' => NULL),
            array('id' => '212', 'title' => 'Suriname', 'title_en' => 'Suriname', 'code' => 'SR', 'deleted_at' => NULL),
            array('id' => '213', 'title' => 'Svalbard and Jan Mayen', 'title_en' => 'Svalbard and Jan Mayen', 'code' => 'SJ', 'deleted_at' => NULL),
            array('id' => '214', 'title' => 'Swaziland', 'title_en' => 'Swaziland', 'code' => 'SZ', 'deleted_at' => NULL),
            array('id' => '215', 'title' => 'Sweden', 'title_en' => 'Sweden', 'code' => 'SE', 'deleted_at' => NULL),
            array('id' => '216', 'title' => 'Switzerland', 'title_en' => 'Switzerland', 'code' => 'CH', 'deleted_at' => NULL),
            array('id' => '217', 'title' => 'Syrian Arab Republic', 'title_en' => 'Syrian Arab Republic', 'code' => 'SY', 'deleted_at' => NULL),
            array('id' => '218', 'title' => 'Taiwan', 'title_en' => 'Taiwan', 'code' => 'TW', 'deleted_at' => NULL),
            array('id' => '219', 'title' => 'Tajikistan', 'title_en' => 'Tajikistan', 'code' => 'TJ', 'deleted_at' => NULL),
            array('id' => '220', 'title' => 'Tanzania, United Republic of', 'title_en' => 'Tanzania, United Republic of', 'code' => 'TZ', 'deleted_at' => NULL),
            array('id' => '221', 'title' => 'Thailand', 'title_en' => 'Thailand', 'code' => 'TH', 'deleted_at' => NULL),
            array('id' => '222', 'title' => 'Timor-Leste', 'title_en' => 'Timor-Leste', 'code' => 'TL', 'deleted_at' => NULL),
            array('id' => '223', 'title' => 'Togo', 'title_en' => 'Togo', 'code' => 'TG', 'deleted_at' => NULL),
            array('id' => '224', 'title' => 'Tokelau', 'title_en' => 'Tokelau', 'code' => 'TK', 'deleted_at' => NULL),
            array('id' => '225', 'title' => 'Tonga', 'title_en' => 'Tonga', 'code' => 'TO', 'deleted_at' => NULL),
            array('id' => '226', 'title' => 'Trinidad and Tobago', 'title_en' => 'Trinidad and Tobago', 'code' => 'TT', 'deleted_at' => NULL),
            array('id' => '227', 'title' => 'Tunisia', 'title_en' => 'Tunisia', 'code' => 'TN', 'deleted_at' => NULL),
            array('id' => '228', 'title' => 'Turkey', 'title_en' => 'Turkey', 'code' => 'TR', 'deleted_at' => NULL),
            array('id' => '229', 'title' => 'Turkmenistan', 'title_en' => 'Turkmenistan', 'code' => 'TM', 'deleted_at' => NULL),
            array('id' => '230', 'title' => 'Turks and Caicos Islands', 'title_en' => 'Turks and Caicos Islands', 'code' => 'TC', 'deleted_at' => NULL),
            array('id' => '231', 'title' => 'Tuvalu', 'title_en' => 'Tuvalu', 'code' => 'TV', 'deleted_at' => NULL),
            array('id' => '232', 'title' => 'Uganda', 'title_en' => 'Uganda', 'code' => 'UG', 'deleted_at' => NULL),
            array('id' => '233', 'title' => 'Ukraine', 'title_en' => 'Ukraine', 'code' => 'UA', 'deleted_at' => NULL),
            array('id' => '234', 'title' => 'United Arab Emirates', 'title_en' => 'United Arab Emirates', 'code' => 'AE', 'deleted_at' => NULL),
            array('id' => '235', 'title' => 'United Kingdom', 'title_en' => 'United Kingdom', 'code' => 'GB', 'deleted_at' => NULL),
            array('id' => '236', 'title' => 'United States', 'title_en' => 'United States', 'code' => 'US', 'deleted_at' => NULL),
            array('id' => '237', 'title' => 'United States Minor Outlying Islands', 'title_en' => 'United States Minor Outlying Islands', 'code' => 'UM', 'deleted_at' => NULL),
            array('id' => '238', 'title' => 'Uruguay', 'title_en' => 'Uruguay', 'code' => 'UY', 'deleted_at' => NULL),
            array('id' => '239', 'title' => 'Uzbekistan', 'title_en' => 'Uzbekistan', 'code' => 'UZ', 'deleted_at' => NULL),
            array('id' => '240', 'title' => 'Vanuatu', 'title_en' => 'Vanuatu', 'code' => 'VU', 'deleted_at' => NULL),
            array('id' => '241', 'title' => 'Venezuela, Bolivarian Republic of', 'title_en' => 'Venezuela, Bolivarian Republic of', 'code' => 'VE', 'deleted_at' => NULL),
            array('id' => '242', 'title' => 'Viet Nam', 'title_en' => 'Viet Nam', 'code' => 'VN', 'deleted_at' => NULL),
            array('id' => '243', 'title' => 'Virgin Islands, British', 'title_en' => 'Virgin Islands, British', 'code' => 'VG', 'deleted_at' => NULL),
            array('id' => '244', 'title' => 'Virgin Islands, U.S.', 'title_en' => 'Virgin Islands, U.S.', 'code' => 'VI', 'deleted_at' => NULL),
            array('id' => '245', 'title' => 'Wallis and Futuna', 'title_en' => 'Wallis and Futuna', 'code' => 'WF', 'deleted_at' => NULL),
            array('id' => '246', 'title' => 'Western Sahara', 'title_en' => 'Western Sahara', 'code' => 'EH', 'deleted_at' => NULL),
            array('id' => '247', 'title' => 'Yemen', 'title_en' => 'Yemen', 'code' => 'YE', 'deleted_at' => NULL),
            array('id' => '248', 'title' => 'Zambia', 'title_en' => 'Zambia', 'code' => 'ZM', 'deleted_at' => NULL),
            array('id' => '249', 'title' => 'Zimbabwe', 'title_en' => 'Zimbabwe', 'code' => 'ZW', 'deleted_at' => NULL)

        ];

        DB::table('countries')->insert($countries);

        Schema::enableForeignKeyConstraints();
    }
}
