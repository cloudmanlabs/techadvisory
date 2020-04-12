@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <x-video />

                <br>
                <br>

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="display:flex; justify-content: space-between">
                                    <h3>View your profile</h3>
                                </div>

                                <p class="welcome_text extra-top-15px">
                                    If any modifications are needed please contact the Accenture team.
                                </p>
                                <br>
                                <br>

                                <div id="wizardVendorProfile">
                                    <h2>Contact information</h2>
                                    <section>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Vendor Name*</label>
                                            <input
                                                class="form-control"
                                                id="exampleInputText1"
                                                placeholder="Enter Name"
                                                type="text"
                                                required
                                                value="{{auth()->user()->name}}"
                                                disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Vendor contact email</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter E-mail"
                                                type="email"
                                                value="{{auth()->user()->name}}"
                                                disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Vendor contact role</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled>Vendor response here</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Address</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled>Vendor response here</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Vendor contact phone</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="+000 000 000" type="text"
                                                value="123456789"
                                                disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Link to your website</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="https://" type="text"
                                                value="https://ideafoster.com"
                                                disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Foundation year</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter year" type="text"
                                                value="1970"
                                                disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Specify Senior Management team (name, title & years in the company)</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="Name, title, years in company" disabled>Vendor response here</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Company Vision</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">High-level development strategy</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label>Headquarters</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple"
                                                required
                                                disabled>
                                                <option value="AF" selected>Afghanistan</option> <option value="AL">Albania</option> <option value="DZ">Algeria</option> <option value="AS">American Samoa</option> <option value="AD">Andorra</option> <option value="AO">Angola</option> <option value="AI">Anguilla</option> <option value="AQ">Antarctica</option> <option value="AG">Antigua and Barbuda</option> <option value="AR">Argentina</option> <option value="AM">Armenia</option> <option value="AW">Aruba</option> <option value="AU">Australia</option> <option value="AT">Austria</option> <option value="AZ">Azerbaijan</option> <option value="BS">Bahamas</option> <option value="BH">Bahrain</option> <option value="BD">Bangladesh</option> <option value="BB">Barbados</option> <option value="BY">Belarus</option> <option value="BE">Belgium</option> <option value="BZ">Belize</option> <option value="BJ">Benin</option> <option value="BM">Bermuda</option> <option value="BT">Bhutan</option> <option value="BO">Bolivia, Plurinational State of</option> <option value="BQ">Bonaire, Sint Eustatius and Saba</option> <option value="BA">Bosnia and Herzegovina</option> <option value="BW">Botswana</option> <option value="BV">Bouvet Island</option> <option value="BR">Brazil</option> <option value="IO">British Indian Ocean Territory</option> <option value="BN">Brunei Darussalam</option> <option value="BG">Bulgaria</option> <option value="BF">Burkina Faso</option> <option value="BI">Burundi</option> <option value="KH">Cambodia</option> <option value="CM">Cameroon</option> <option value="CA">Canada</option> <option value="CV">Cape Verde</option> <option value="KY">Cayman Islands</option> <option value="CF">Central African Republic</option> <option value="TD">Chad</option> <option value="CL">Chile</option> <option value="CN">China</option> <option value="CX">Christmas Island</option> <option value="CC">Cocos (Keeling) Islands</option> <option value="CO">Colombia</option> <option value="KM">Comoros</option> <option value="CG">Congo</option> <option value="CD">Congo, the Democratic Republic of the</option> <option value="CK">Cook Islands</option> <option value="CR">Costa Rica</option> <option value="CI">Côte d'Ivoire</option> <option value="HR">Croatia</option> <option value="CU">Cuba</option> <option value="CW">Curaçao</option> <option value="CY">Cyprus</option> <option value="CZ">Czech Republic</option> <option value="DK">Denmark</option> <option value="DJ">Djibouti</option> <option value="DM">Dominica</option> <option value="DO">Dominican Republic</option> <option value="EC">Ecuador</option> <option value="EG">Egypt</option> <option value="SV">El Salvador</option> <option value="GQ">Equatorial Guinea</option> <option value="ER">Eritrea</option> <option value="EE">Estonia</option> <option value="ET">Ethiopia</option> <option value="FK">Falkland Islands (Malvinas)</option> <option value="FO">Faroe Islands</option> <option value="FJ">Fiji</option> <option value="FI">Finland</option> <option value="FR">France</option> <option value="GF">French Guiana</option> <option value="PF">French Polynesia</option> <option value="TF">French Southern Territories</option> <option value="GA">Gabon</option> <option value="GM">Gambia</option> <option value="GE">Georgia</option> <option value="DE">Germany</option> <option value="GH">Ghana</option> <option value="GI">Gibraltar</option> <option value="GR">Greece</option> <option value="GL">Greenland</option> <option value="GD">Grenada</option> <option value="GP">Guadeloupe</option> <option value="GU">Guam</option> <option value="GT">Guatemala</option> <option value="GG">Guernsey</option> <option value="GN">Guinea</option> <option value="GW">Guinea-Bissau</option> <option value="GY">Guyana</option> <option value="HT">Haiti</option> <option value="HM">Heard Island and McDonald Islands</option> <option value="VA">Holy See (Vatican City State)</option> <option value="HN">Honduras</option> <option value="HK">Hong Kong</option> <option value="HU">Hungary</option> <option value="IS">Iceland</option> <option value="IN">India</option> <option value="ID">Indonesia</option> <option value="IR">Iran, Islamic Republic of</option> <option value="IQ">Iraq</option> <option value="IE">Ireland</option> <option value="IM">Isle of Man</option> <option value="IL">Israel</option> <option value="IT">Italy</option> <option value="JM">Jamaica</option> <option value="JP">Japan</option> <option value="JE">Jersey</option> <option value="JO">Jordan</option> <option value="KZ">Kazakhstan</option> <option value="KE">Kenya</option> <option value="KI">Kiribati</option> <option value="KP">Korea, Democratic People's Republic of</option> <option value="KR">Korea, Republic of</option> <option value="KW">Kuwait</option> <option value="KG">Kyrgyzstan</option> <option value="LA">Lao People's Democratic Republic</option> <option value="LV">Latvia</option> <option value="LB">Lebanon</option> <option value="LS">Lesotho</option> <option value="LR">Liberia</option> <option value="LY">Libya</option> <option value="LI">Liechtenstein</option> <option value="LT">Lithuania</option> <option value="LU">Luxembourg</option> <option value="MO">Macao</option> <option value="MK">Macedonia, the former Yugoslav Republic of</option> <option value="MG">Madagascar</option> <option value="MW">Malawi</option> <option value="MY">Malaysia</option> <option value="MV">Maldives</option> <option value="ML">Mali</option> <option value="MT">Malta</option> <option value="MH">Marshall Islands</option> <option value="MQ">Martinique</option> <option value="MR">Mauritania</option> <option value="MU">Mauritius</option> <option value="YT">Mayotte</option> <option value="MX">Mexico</option> <option value="FM">Micronesia, Federated States of</option> <option value="MD">Moldova, Republic of</option> <option value="MC">Monaco</option> <option value="MN">Mongolia</option> <option value="ME">Montenegro</option> <option value="MS">Montserrat</option> <option value="MA">Morocco</option> <option value="MZ">Mozambique</option> <option value="MM">Myanmar</option> <option value="NA">Namibia</option> <option value="NR">Nauru</option> <option value="NP">Nepal</option> <option value="NL">Netherlands</option> <option value="NC">New Caledonia</option> <option value="NZ">New Zealand</option> <option value="NI">Nicaragua</option> <option value="NE">Niger</option> <option value="NG">Nigeria</option> <option value="NU">Niue</option> <option value="NF">Norfolk Island</option> <option value="MP">Northern Mariana Islands</option> <option value="NO">Norway</option> <option value="OM">Oman</option> <option value="PK">Pakistan</option> <option value="PW">Palau</option> <option value="PS">Palestinian Territory, Occupied</option> <option value="PA">Panama</option> <option value="PG">Papua New Guinea</option> <option value="PY">Paraguay</option> <option value="PE">Peru</option> <option value="PH">Philippines</option> <option value="PN">Pitcairn</option> <option value="PL">Poland</option> <option value="PT">Portugal</option> <option value="PR">Puerto Rico</option> <option value="QA">Qatar</option> <option value="RE">Réunion</option> <option value="RO">Romania</option> <option value="RU">Russian Federation</option> <option value="RW">Rwanda</option> <option value="BL">Saint Barthélemy</option> <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option> <option value="KN">Saint Kitts and Nevis</option> <option value="LC">Saint Lucia</option> <option value="MF">Saint Martin (French part)</option> <option value="PM">Saint Pierre and Miquelon</option> <option value="VC">Saint Vincent and the Grenadines</option> <option value="WS">Samoa</option> <option value="SM">San Marino</option> <option value="ST">Sao Tome and Principe</option> <option value="SA">Saudi Arabia</option> <option value="SN">Senegal</option> <option value="RS">Serbia</option> <option value="SC">Seychelles</option> <option value="SL">Sierra Leone</option> <option value="SG">Singapore</option> <option value="SX">Sint Maarten (Dutch part)</option> <option value="SK">Slovakia</option> <option value="SI">Slovenia</option> <option value="SB">Solomon Islands</option> <option value="SO">Somalia</option> <option value="ZA">South Africa</option> <option value="GS">South Georgia and the South Sandwich Islands</option> <option value="SS">South Sudan</option> <option value="ES">Spain</option> <option value="LK">Sri Lanka</option> <option value="SD">Sudan</option> <option value="SR">Suriname</option> <option value="SJ">Svalbard and Jan Mayen</option> <option value="SZ">Swaziland</option> <option value="SE">Sweden</option> <option value="CH">Switzerland</option> <option value="SY">Syrian Arab Republic</option> <option value="TW">Taiwan, Province of China</option> <option value="TJ">Tajikistan</option> <option value="TZ">Tanzania, United Republic of</option> <option value="TH">Thailand</option> <option value="TL">Timor-Leste</option> <option value="TG">Togo</option> <option value="TK">Tokelau</option> <option value="TO">Tonga</option> <option value="TT">Trinidad and Tobago</option> <option value="TN">Tunisia</option> <option value="TR">Turkey</option> <option value="TM">Turkmenistan</option> <option value="TC">Turks and Caicos Islands</option> <option value="TV">Tuvalu</option> <option value="UG">Uganda</option> <option value="UA">Ukraine</option> <option value="AE">United Arab Emirates</option> <option value="GB">United Kingdom</option> <option value="US">United States</option> <option value="UM">United States Minor Outlying Islands</option> <option value="UY">Uruguay</option> <option value="UZ">Uzbekistan</option> <option value="VU">Vanuatu</option> <option value="VE">Venezuela, Bolivarian Republic of</option> <option value="VN">Viet Nam</option> <option value="VG">Virgin Islands, British</option> <option value="VI">Virgin Islands, U.S.</option> <option value="WF">Wallis and Futuna</option> <option value="EH">Western Sahara</option> <option value="YE">Yemen</option> <option value="ZM">Zambia</option> <option value="ZW">Zimbabwe</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Commercials Offices</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" required disabled>
                                                <option value="AF" selected>Afghanistan</option> <option value="AL">Albania</option> <option value="DZ">Algeria</option> <option value="AS">American Samoa</option> <option value="AD">Andorra</option> <option value="AO">Angola</option> <option value="AI">Anguilla</option> <option value="AQ">Antarctica</option> <option value="AG">Antigua and Barbuda</option> <option value="AR">Argentina</option> <option value="AM">Armenia</option> <option value="AW">Aruba</option> <option value="AU">Australia</option> <option value="AT">Austria</option> <option value="AZ">Azerbaijan</option> <option value="BS">Bahamas</option> <option value="BH">Bahrain</option> <option value="BD">Bangladesh</option> <option value="BB">Barbados</option> <option value="BY">Belarus</option> <option value="BE">Belgium</option> <option value="BZ">Belize</option> <option value="BJ">Benin</option> <option value="BM">Bermuda</option> <option value="BT">Bhutan</option> <option value="BO">Bolivia, Plurinational State of</option> <option value="BQ">Bonaire, Sint Eustatius and Saba</option> <option value="BA">Bosnia and Herzegovina</option> <option value="BW">Botswana</option> <option value="BV">Bouvet Island</option> <option value="BR">Brazil</option> <option value="IO">British Indian Ocean Territory</option> <option value="BN">Brunei Darussalam</option> <option value="BG">Bulgaria</option> <option value="BF">Burkina Faso</option> <option value="BI">Burundi</option> <option value="KH">Cambodia</option> <option value="CM">Cameroon</option> <option value="CA">Canada</option> <option value="CV">Cape Verde</option> <option value="KY">Cayman Islands</option> <option value="CF">Central African Republic</option> <option value="TD">Chad</option> <option value="CL">Chile</option> <option value="CN">China</option> <option value="CX">Christmas Island</option> <option value="CC">Cocos (Keeling) Islands</option> <option value="CO">Colombia</option> <option value="KM">Comoros</option> <option value="CG">Congo</option> <option value="CD">Congo, the Democratic Republic of the</option> <option value="CK">Cook Islands</option> <option value="CR">Costa Rica</option> <option value="CI">Côte d'Ivoire</option> <option value="HR">Croatia</option> <option value="CU">Cuba</option> <option value="CW">Curaçao</option> <option value="CY">Cyprus</option> <option value="CZ">Czech Republic</option> <option value="DK">Denmark</option> <option value="DJ">Djibouti</option> <option value="DM">Dominica</option> <option value="DO">Dominican Republic</option> <option value="EC">Ecuador</option> <option value="EG">Egypt</option> <option value="SV">El Salvador</option> <option value="GQ">Equatorial Guinea</option> <option value="ER">Eritrea</option> <option value="EE">Estonia</option> <option value="ET">Ethiopia</option> <option value="FK">Falkland Islands (Malvinas)</option> <option value="FO">Faroe Islands</option> <option value="FJ">Fiji</option> <option value="FI">Finland</option> <option value="FR">France</option> <option value="GF">French Guiana</option> <option value="PF">French Polynesia</option> <option value="TF">French Southern Territories</option> <option value="GA">Gabon</option> <option value="GM">Gambia</option> <option value="GE">Georgia</option> <option value="DE">Germany</option> <option value="GH">Ghana</option> <option value="GI">Gibraltar</option> <option value="GR">Greece</option> <option value="GL">Greenland</option> <option value="GD">Grenada</option> <option value="GP">Guadeloupe</option> <option value="GU">Guam</option> <option value="GT">Guatemala</option> <option value="GG">Guernsey</option> <option value="GN">Guinea</option> <option value="GW">Guinea-Bissau</option> <option value="GY">Guyana</option> <option value="HT">Haiti</option> <option value="HM">Heard Island and McDonald Islands</option> <option value="VA">Holy See (Vatican City State)</option> <option value="HN">Honduras</option> <option value="HK">Hong Kong</option> <option value="HU">Hungary</option> <option value="IS">Iceland</option> <option value="IN">India</option> <option value="ID">Indonesia</option> <option value="IR">Iran, Islamic Republic of</option> <option value="IQ">Iraq</option> <option value="IE">Ireland</option> <option value="IM">Isle of Man</option> <option value="IL">Israel</option> <option value="IT">Italy</option> <option value="JM">Jamaica</option> <option value="JP">Japan</option> <option value="JE">Jersey</option> <option value="JO">Jordan</option> <option value="KZ">Kazakhstan</option> <option value="KE">Kenya</option> <option value="KI">Kiribati</option> <option value="KP">Korea, Democratic People's Republic of</option> <option value="KR">Korea, Republic of</option> <option value="KW">Kuwait</option> <option value="KG">Kyrgyzstan</option> <option value="LA">Lao People's Democratic Republic</option> <option value="LV">Latvia</option> <option value="LB">Lebanon</option> <option value="LS">Lesotho</option> <option value="LR">Liberia</option> <option value="LY">Libya</option> <option value="LI">Liechtenstein</option> <option value="LT">Lithuania</option> <option value="LU">Luxembourg</option> <option value="MO">Macao</option> <option value="MK">Macedonia, the former Yugoslav Republic of</option> <option value="MG">Madagascar</option> <option value="MW">Malawi</option> <option value="MY">Malaysia</option> <option value="MV">Maldives</option> <option value="ML">Mali</option> <option value="MT">Malta</option> <option value="MH">Marshall Islands</option> <option value="MQ">Martinique</option> <option value="MR">Mauritania</option> <option value="MU">Mauritius</option> <option value="YT">Mayotte</option> <option value="MX">Mexico</option> <option value="FM">Micronesia, Federated States of</option> <option value="MD">Moldova, Republic of</option> <option value="MC">Monaco</option> <option value="MN">Mongolia</option> <option value="ME">Montenegro</option> <option value="MS">Montserrat</option> <option value="MA">Morocco</option> <option value="MZ">Mozambique</option> <option value="MM">Myanmar</option> <option value="NA">Namibia</option> <option value="NR">Nauru</option> <option value="NP">Nepal</option> <option value="NL">Netherlands</option> <option value="NC">New Caledonia</option> <option value="NZ">New Zealand</option> <option value="NI">Nicaragua</option> <option value="NE">Niger</option> <option value="NG">Nigeria</option> <option value="NU">Niue</option> <option value="NF">Norfolk Island</option> <option value="MP">Northern Mariana Islands</option> <option value="NO">Norway</option> <option value="OM">Oman</option> <option value="PK">Pakistan</option> <option value="PW">Palau</option> <option value="PS">Palestinian Territory, Occupied</option> <option value="PA">Panama</option> <option value="PG">Papua New Guinea</option> <option value="PY">Paraguay</option> <option value="PE">Peru</option> <option value="PH">Philippines</option> <option value="PN">Pitcairn</option> <option value="PL">Poland</option> <option value="PT">Portugal</option> <option value="PR">Puerto Rico</option> <option value="QA">Qatar</option> <option value="RE">Réunion</option> <option value="RO">Romania</option> <option value="RU">Russian Federation</option> <option value="RW">Rwanda</option> <option value="BL">Saint Barthélemy</option> <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option> <option value="KN">Saint Kitts and Nevis</option> <option value="LC">Saint Lucia</option> <option value="MF">Saint Martin (French part)</option> <option value="PM">Saint Pierre and Miquelon</option> <option value="VC">Saint Vincent and the Grenadines</option> <option value="WS">Samoa</option> <option value="SM">San Marino</option> <option value="ST">Sao Tome and Principe</option> <option value="SA">Saudi Arabia</option> <option value="SN">Senegal</option> <option value="RS">Serbia</option> <option value="SC">Seychelles</option> <option value="SL">Sierra Leone</option> <option value="SG">Singapore</option> <option value="SX">Sint Maarten (Dutch part)</option> <option value="SK">Slovakia</option> <option value="SI">Slovenia</option> <option value="SB">Solomon Islands</option> <option value="SO">Somalia</option> <option value="ZA">South Africa</option> <option value="GS">South Georgia and the South Sandwich Islands</option> <option value="SS">South Sudan</option> <option value="ES">Spain</option> <option value="LK">Sri Lanka</option> <option value="SD">Sudan</option> <option value="SR">Suriname</option> <option value="SJ">Svalbard and Jan Mayen</option> <option value="SZ">Swaziland</option> <option value="SE">Sweden</option> <option value="CH">Switzerland</option> <option value="SY">Syrian Arab Republic</option> <option value="TW">Taiwan, Province of China</option> <option value="TJ">Tajikistan</option> <option value="TZ">Tanzania, United Republic of</option> <option value="TH">Thailand</option> <option value="TL">Timor-Leste</option> <option value="TG">Togo</option> <option value="TK">Tokelau</option> <option value="TO">Tonga</option> <option value="TT">Trinidad and Tobago</option> <option value="TN">Tunisia</option> <option value="TR">Turkey</option> <option value="TM">Turkmenistan</option> <option value="TC">Turks and Caicos Islands</option> <option value="TV">Tuvalu</option> <option value="UG">Uganda</option> <option value="UA">Ukraine</option> <option value="AE">United Arab Emirates</option> <option value="GB">United Kingdom</option> <option value="US">United States</option> <option value="UM">United States Minor Outlying Islands</option> <option value="UY">Uruguay</option> <option value="UZ">Uzbekistan</option> <option value="VU">Vanuatu</option> <option value="VE">Venezuela, Bolivarian Republic of</option> <option value="VN">Viet Nam</option> <option value="VG">Virgin Islands, British</option> <option value="VI">Virgin Islands, U.S.</option> <option value="WF">Wallis and Futuna</option> <option value="EH">Western Sahara</option> <option value="YE">Yemen</option> <option value="ZM">Zambia</option> <option value="ZW">Zimbabwe</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Services Team Offices</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" required disabled>
                                                <option value="AF" selected>Afghanistan</option> <option value="AL">Albania</option> <option value="DZ">Algeria</option> <option value="AS">American Samoa</option> <option value="AD">Andorra</option> <option value="AO">Angola</option> <option value="AI">Anguilla</option> <option value="AQ">Antarctica</option> <option value="AG">Antigua and Barbuda</option> <option value="AR">Argentina</option> <option value="AM">Armenia</option> <option value="AW">Aruba</option> <option value="AU">Australia</option> <option value="AT">Austria</option> <option value="AZ">Azerbaijan</option> <option value="BS">Bahamas</option> <option value="BH">Bahrain</option> <option value="BD">Bangladesh</option> <option value="BB">Barbados</option> <option value="BY">Belarus</option> <option value="BE">Belgium</option> <option value="BZ">Belize</option> <option value="BJ">Benin</option> <option value="BM">Bermuda</option> <option value="BT">Bhutan</option> <option value="BO">Bolivia, Plurinational State of</option> <option value="BQ">Bonaire, Sint Eustatius and Saba</option> <option value="BA">Bosnia and Herzegovina</option> <option value="BW">Botswana</option> <option value="BV">Bouvet Island</option> <option value="BR">Brazil</option> <option value="IO">British Indian Ocean Territory</option> <option value="BN">Brunei Darussalam</option> <option value="BG">Bulgaria</option> <option value="BF">Burkina Faso</option> <option value="BI">Burundi</option> <option value="KH">Cambodia</option> <option value="CM">Cameroon</option> <option value="CA">Canada</option> <option value="CV">Cape Verde</option> <option value="KY">Cayman Islands</option> <option value="CF">Central African Republic</option> <option value="TD">Chad</option> <option value="CL">Chile</option> <option value="CN">China</option> <option value="CX">Christmas Island</option> <option value="CC">Cocos (Keeling) Islands</option> <option value="CO">Colombia</option> <option value="KM">Comoros</option> <option value="CG">Congo</option> <option value="CD">Congo, the Democratic Republic of the</option> <option value="CK">Cook Islands</option> <option value="CR">Costa Rica</option> <option value="CI">Côte d'Ivoire</option> <option value="HR">Croatia</option> <option value="CU">Cuba</option> <option value="CW">Curaçao</option> <option value="CY">Cyprus</option> <option value="CZ">Czech Republic</option> <option value="DK">Denmark</option> <option value="DJ">Djibouti</option> <option value="DM">Dominica</option> <option value="DO">Dominican Republic</option> <option value="EC">Ecuador</option> <option value="EG">Egypt</option> <option value="SV">El Salvador</option> <option value="GQ">Equatorial Guinea</option> <option value="ER">Eritrea</option> <option value="EE">Estonia</option> <option value="ET">Ethiopia</option> <option value="FK">Falkland Islands (Malvinas)</option> <option value="FO">Faroe Islands</option> <option value="FJ">Fiji</option> <option value="FI">Finland</option> <option value="FR">France</option> <option value="GF">French Guiana</option> <option value="PF">French Polynesia</option> <option value="TF">French Southern Territories</option> <option value="GA">Gabon</option> <option value="GM">Gambia</option> <option value="GE">Georgia</option> <option value="DE">Germany</option> <option value="GH">Ghana</option> <option value="GI">Gibraltar</option> <option value="GR">Greece</option> <option value="GL">Greenland</option> <option value="GD">Grenada</option> <option value="GP">Guadeloupe</option> <option value="GU">Guam</option> <option value="GT">Guatemala</option> <option value="GG">Guernsey</option> <option value="GN">Guinea</option> <option value="GW">Guinea-Bissau</option> <option value="GY">Guyana</option> <option value="HT">Haiti</option> <option value="HM">Heard Island and McDonald Islands</option> <option value="VA">Holy See (Vatican City State)</option> <option value="HN">Honduras</option> <option value="HK">Hong Kong</option> <option value="HU">Hungary</option> <option value="IS">Iceland</option> <option value="IN">India</option> <option value="ID">Indonesia</option> <option value="IR">Iran, Islamic Republic of</option> <option value="IQ">Iraq</option> <option value="IE">Ireland</option> <option value="IM">Isle of Man</option> <option value="IL">Israel</option> <option value="IT">Italy</option> <option value="JM">Jamaica</option> <option value="JP">Japan</option> <option value="JE">Jersey</option> <option value="JO">Jordan</option> <option value="KZ">Kazakhstan</option> <option value="KE">Kenya</option> <option value="KI">Kiribati</option> <option value="KP">Korea, Democratic People's Republic of</option> <option value="KR">Korea, Republic of</option> <option value="KW">Kuwait</option> <option value="KG">Kyrgyzstan</option> <option value="LA">Lao People's Democratic Republic</option> <option value="LV">Latvia</option> <option value="LB">Lebanon</option> <option value="LS">Lesotho</option> <option value="LR">Liberia</option> <option value="LY">Libya</option> <option value="LI">Liechtenstein</option> <option value="LT">Lithuania</option> <option value="LU">Luxembourg</option> <option value="MO">Macao</option> <option value="MK">Macedonia, the former Yugoslav Republic of</option> <option value="MG">Madagascar</option> <option value="MW">Malawi</option> <option value="MY">Malaysia</option> <option value="MV">Maldives</option> <option value="ML">Mali</option> <option value="MT">Malta</option> <option value="MH">Marshall Islands</option> <option value="MQ">Martinique</option> <option value="MR">Mauritania</option> <option value="MU">Mauritius</option> <option value="YT">Mayotte</option> <option value="MX">Mexico</option> <option value="FM">Micronesia, Federated States of</option> <option value="MD">Moldova, Republic of</option> <option value="MC">Monaco</option> <option value="MN">Mongolia</option> <option value="ME">Montenegro</option> <option value="MS">Montserrat</option> <option value="MA">Morocco</option> <option value="MZ">Mozambique</option> <option value="MM">Myanmar</option> <option value="NA">Namibia</option> <option value="NR">Nauru</option> <option value="NP">Nepal</option> <option value="NL">Netherlands</option> <option value="NC">New Caledonia</option> <option value="NZ">New Zealand</option> <option value="NI">Nicaragua</option> <option value="NE">Niger</option> <option value="NG">Nigeria</option> <option value="NU">Niue</option> <option value="NF">Norfolk Island</option> <option value="MP">Northern Mariana Islands</option> <option value="NO">Norway</option> <option value="OM">Oman</option> <option value="PK">Pakistan</option> <option value="PW">Palau</option> <option value="PS">Palestinian Territory, Occupied</option> <option value="PA">Panama</option> <option value="PG">Papua New Guinea</option> <option value="PY">Paraguay</option> <option value="PE">Peru</option> <option value="PH">Philippines</option> <option value="PN">Pitcairn</option> <option value="PL">Poland</option> <option value="PT">Portugal</option> <option value="PR">Puerto Rico</option> <option value="QA">Qatar</option> <option value="RE">Réunion</option> <option value="RO">Romania</option> <option value="RU">Russian Federation</option> <option value="RW">Rwanda</option> <option value="BL">Saint Barthélemy</option> <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option> <option value="KN">Saint Kitts and Nevis</option> <option value="LC">Saint Lucia</option> <option value="MF">Saint Martin (French part)</option> <option value="PM">Saint Pierre and Miquelon</option> <option value="VC">Saint Vincent and the Grenadines</option> <option value="WS">Samoa</option> <option value="SM">San Marino</option> <option value="ST">Sao Tome and Principe</option> <option value="SA">Saudi Arabia</option> <option value="SN">Senegal</option> <option value="RS">Serbia</option> <option value="SC">Seychelles</option> <option value="SL">Sierra Leone</option> <option value="SG">Singapore</option> <option value="SX">Sint Maarten (Dutch part)</option> <option value="SK">Slovakia</option> <option value="SI">Slovenia</option> <option value="SB">Solomon Islands</option> <option value="SO">Somalia</option> <option value="ZA">South Africa</option> <option value="GS">South Georgia and the South Sandwich Islands</option> <option value="SS">South Sudan</option> <option value="ES">Spain</option> <option value="LK">Sri Lanka</option> <option value="SD">Sudan</option> <option value="SR">Suriname</option> <option value="SJ">Svalbard and Jan Mayen</option> <option value="SZ">Swaziland</option> <option value="SE">Sweden</option> <option value="CH">Switzerland</option> <option value="SY">Syrian Arab Republic</option> <option value="TW">Taiwan, Province of China</option> <option value="TJ">Tajikistan</option> <option value="TZ">Tanzania, United Republic of</option> <option value="TH">Thailand</option> <option value="TL">Timor-Leste</option> <option value="TG">Togo</option> <option value="TK">Tokelau</option> <option value="TO">Tonga</option> <option value="TT">Trinidad and Tobago</option> <option value="TN">Tunisia</option> <option value="TR">Turkey</option> <option value="TM">Turkmenistan</option> <option value="TC">Turks and Caicos Islands</option> <option value="TV">Tuvalu</option> <option value="UG">Uganda</option> <option value="UA">Ukraine</option> <option value="AE">United Arab Emirates</option> <option value="GB">United Kingdom</option> <option value="US">United States</option> <option value="UM">United States Minor Outlying Islands</option> <option value="UY">Uruguay</option> <option value="UZ">Uzbekistan</option> <option value="VU">Vanuatu</option> <option value="VE">Venezuela, Bolivarian Republic of</option> <option value="VN">Viet Nam</option> <option value="VG">Virgin Islands, British</option> <option value="VI">Virgin Islands, U.S.</option> <option value="WF">Wallis and Futuna</option> <option value="EH">Western Sahara</option> <option value="YE">Yemen</option> <option value="ZM">Zambia</option> <option value="ZW">Zimbabwe</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Vendor segment</label>
                                            <select class="js-example-basic-multiple w-100" multiple="multiple" required disabled>
                                                <option selected>Megasuite</option>
                                                <option>SCM suite</option>
                                                <option>Specific solution</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Number of employees</label>
                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                <option disabled>
                                                    Please select the range
                                                </option>
                                                <option selected>
                                                    0-50
                                                </option>
                                                <option>
                                                    50-500
                                                </option>
                                                <option>
                                                    500-5.000
                                                </option>
                                                <option>
                                                    5.000 – 30.000
                                                </option>
                                                <option>
                                                    + 30.000
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputText1">Number of employees in R&D</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter number" type="number"
                                                disabled
                                                value="3">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Geographies with solution implementations</label>
                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                <option disabled>
                                                    Please select the area served
                                                </option>
                                                <option selected>
                                                    Worldwide
                                                </option>
                                                <option>
                                                    EMEA
                                                </option>
                                                <option>
                                                    APAC
                                                </option>
                                                <option>
                                                    NA
                                                </option>
                                                <option>
                                                    LATAM
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Industry Experience</label>
                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                <option disabled>
                                                    Please select your industry
                                                </option>
                                                <option selected>
                                                    Automative
                                                </option>
                                                <option>
                                                    Consumer goods & services
                                                </option>
                                                <option>
                                                    Industrial Equipement
                                                </option>
                                                <option>
                                                    Life Sciences
                                                </option>
                                                <option>
                                                    Retail
                                                </option>
                                                <option>
                                                    Transport services
                                                </option>
                                                <option>
                                                    Travel
                                                </option>
                                                <option>
                                                    Chemical
                                                </option>
                                                <option>
                                                    Energy
                                                </option>
                                                <option>
                                                    Natural Resources
                                                </option>
                                                <option>
                                                    Utilities
                                                </option>
                                                <option>
                                                    Communications & Media
                                                </option>
                                                <option>
                                                    High tech
                                                </option>
                                                <option>
                                                    CMT SW&P
                                                </option>
                                                <option>
                                                    Health
                                                </option>
                                                <option>
                                                    Public Service
                                                </option>
                                                <option>
                                                    Banking
                                                </option>
                                                <option>
                                                    Capital Markets
                                                </option>
                                                <option>
                                                    Insurance
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Upload your logo</label> <input class="file-upload-default" name="img[]" type="file">

                                            <div class="input-group col-xs-12">
                                                <input class="form-control file-upload-info" disabled placeholder="Upload Image" type="text" disabled> <span class="input-group-append"><button class="file-upload-browse btn btn-primary" type="button"><span class="input-group-append">Upload</span></button></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputText1">Upload any extra files</label>

                                            <form action="/file-upload" class="dropzone" id="exampleDropzone" name="exampleDropzone">
                                            </form>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Partnerships</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Indicate if your company is Public or private</label>
                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                <option disabled>
                                                    Please select
                                                </option>
                                                <option selected>
                                                    Public
                                                </option>
                                                <option>
                                                    Private
                                                </option>
                                            </select>
                                        </div>
                                    </section>


                                    <h2>Company information</h2>
                                    <section>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Stock exchange and ticker symbol</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter Stock / ticker"
                                                type="text"
                                                disabled
                                                value="SPY">
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Describe ownership structure (attach additional information if required)</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Month in which fiscal year ends</label>
                                            <input class="form-control" id="exampleInputText1" placeholder="Enter month"
                                                type="text"
                                                disabled
                                                value="Monday">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Finance currency</label>
                                            <select class="form-control" id="exampleFormControlSelect1" disabled>
                                                <option disabled selected>
                                                    Please select
                                                </option>
                                                <option selected>
                                                    €
                                                </option>
                                                <option>
                                                    USD
                                                </option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Indicate YTD Results 2020 - Revenue, Profit, R&D Expenses</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Indicate 2019 Results - Revenue, Profit, R&D Expenses</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Indicate 2018 Results - Revenue, Profit, R&D Expenses</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Current Balance Sheet Information</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>



                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Cash and cash equivalents</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Other current assets</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Current liabilities</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Quick ratio (current assets - current liabilities)</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Total amount of debt</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>

                                    </section>


                                    <h2>Economic information</h2>
                                    <section>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Any litigation pending?</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Number of lawsuits in history of company?</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Are you currently in any discussions about being acquired? </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="" disabled>Vendor response here</textarea>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
@endsection
