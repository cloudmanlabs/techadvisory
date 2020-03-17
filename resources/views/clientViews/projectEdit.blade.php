@extends('clientViews.layouts.forms')

@section('content')
<div class="main-wrapper">
    <x-client.navbar activeSection="home" />

    <div class="page-wrapper">
        <div class="page-content">
            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                <div>
                    <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                </div>
            </div>

            <x-client.projectNavbar section="projectEdit" />

            <br>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit project information</h3>
                            <br>
                            <div class="alert alert-warning" role="alert">Please note that this project is currently live and receiving applications from vendors. Edit it at your own discretion.</div>

                            <br>
                            <div id="wizard">
                                <h2>General Info</h2>
                                <section>
                                    <h4>1.1. Project Info</h4>
                                    <br>

                                    <div class="form-group">
                                        <label for="exampleInputText1">Project Name</label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="Project Name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputText1">Client contact e-mail</label>
                                        <input type="email" class="form-control" id="exampleInputText1" placeholder="Client contact e-mail" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputText1">Client telefono</label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="Client telefono">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputText1">Accenture contact e-mail</label>
                                        <input type="email" class="form-control" id="exampleInputText1" placeholder="Accenture contact e-mail" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputText1">Accenure telefono</label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="Accenure telefono">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Project Type</label>
                                        <select class="form-control" id="exampleFormControlSelect1" required>
                                            <option selected="" disabled="">Please select the Project Type</option>
                                            <option>Transportation Business Case</option>
                                            <option>Software selection</option>
                                            <option>Value Based Software Selection</option>
                                            <option>Client Satisfaction Survey</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Project description</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="14" required></textarea>
                                    </div>
                                    <br>

                                    <h4>1.2. Scope</h4>
                                    <br>


                                    <div class="form-group">
                                        <label>Region Served</label>
                                        <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                            <option value="AF">Afghanistan</option> <option value="AL">Albania</option> <option value="DZ">Algeria</option> <option value="AS">American Samoa</option> <option value="AD">Andorra</option> <option value="AO">Angola</option> <option value="AI">Anguilla</option> <option value="AQ">Antarctica</option> <option value="AG">Antigua and Barbuda</option> <option value="AR">Argentina</option> <option value="AM">Armenia</option> <option value="AW">Aruba</option> <option value="AU">Australia</option> <option value="AT">Austria</option> <option value="AZ">Azerbaijan</option> <option value="BS">Bahamas</option> <option value="BH">Bahrain</option> <option value="BD">Bangladesh</option> <option value="BB">Barbados</option> <option value="BY">Belarus</option> <option value="BE">Belgium</option> <option value="BZ">Belize</option> <option value="BJ">Benin</option> <option value="BM">Bermuda</option> <option value="BT">Bhutan</option> <option value="BO">Bolivia, Plurinational State of</option> <option value="BQ">Bonaire, Sint Eustatius and Saba</option> <option value="BA">Bosnia and Herzegovina</option> <option value="BW">Botswana</option> <option value="BV">Bouvet Island</option> <option value="BR">Brazil</option> <option value="IO">British Indian Ocean Territory</option> <option value="BN">Brunei Darussalam</option> <option value="BG">Bulgaria</option> <option value="BF">Burkina Faso</option> <option value="BI">Burundi</option> <option value="KH">Cambodia</option> <option value="CM">Cameroon</option> <option value="CA">Canada</option> <option value="CV">Cape Verde</option> <option value="KY">Cayman Islands</option> <option value="CF">Central African Republic</option> <option value="TD">Chad</option> <option value="CL">Chile</option> <option value="CN">China</option> <option value="CX">Christmas Island</option> <option value="CC">Cocos (Keeling) Islands</option> <option value="CO">Colombia</option> <option value="KM">Comoros</option> <option value="CG">Congo</option> <option value="CD">Congo, the Democratic Republic of the</option> <option value="CK">Cook Islands</option> <option value="CR">Costa Rica</option> <option value="CI">Côte d'Ivoire</option> <option value="HR">Croatia</option> <option value="CU">Cuba</option> <option value="CW">Curaçao</option> <option value="CY">Cyprus</option> <option value="CZ">Czech Republic</option> <option value="DK">Denmark</option> <option value="DJ">Djibouti</option> <option value="DM">Dominica</option> <option value="DO">Dominican Republic</option> <option value="EC">Ecuador</option> <option value="EG">Egypt</option> <option value="SV">El Salvador</option> <option value="GQ">Equatorial Guinea</option> <option value="ER">Eritrea</option> <option value="EE">Estonia</option> <option value="ET">Ethiopia</option> <option value="FK">Falkland Islands (Malvinas)</option> <option value="FO">Faroe Islands</option> <option value="FJ">Fiji</option> <option value="FI">Finland</option> <option value="FR">France</option> <option value="GF">French Guiana</option> <option value="PF">French Polynesia</option> <option value="TF">French Southern Territories</option> <option value="GA">Gabon</option> <option value="GM">Gambia</option> <option value="GE">Georgia</option> <option value="DE">Germany</option> <option value="GH">Ghana</option> <option value="GI">Gibraltar</option> <option value="GR">Greece</option> <option value="GL">Greenland</option> <option value="GD">Grenada</option> <option value="GP">Guadeloupe</option> <option value="GU">Guam</option> <option value="GT">Guatemala</option> <option value="GG">Guernsey</option> <option value="GN">Guinea</option> <option value="GW">Guinea-Bissau</option> <option value="GY">Guyana</option> <option value="HT">Haiti</option> <option value="HM">Heard Island and McDonald Islands</option> <option value="VA">Holy See (Vatican City State)</option> <option value="HN">Honduras</option> <option value="HK">Hong Kong</option> <option value="HU">Hungary</option> <option value="IS">Iceland</option> <option value="IN">India</option> <option value="ID">Indonesia</option> <option value="IR">Iran, Islamic Republic of</option> <option value="IQ">Iraq</option> <option value="IE">Ireland</option> <option value="IM">Isle of Man</option> <option value="IL">Israel</option> <option value="IT">Italy</option> <option value="JM">Jamaica</option> <option value="JP">Japan</option> <option value="JE">Jersey</option> <option value="JO">Jordan</option> <option value="KZ">Kazakhstan</option> <option value="KE">Kenya</option> <option value="KI">Kiribati</option> <option value="KP">Korea, Democratic People's Republic of</option> <option value="KR">Korea, Republic of</option> <option value="KW">Kuwait</option> <option value="KG">Kyrgyzstan</option> <option value="LA">Lao People's Democratic Republic</option> <option value="LV">Latvia</option> <option value="LB">Lebanon</option> <option value="LS">Lesotho</option> <option value="LR">Liberia</option> <option value="LY">Libya</option> <option value="LI">Liechtenstein</option> <option value="LT">Lithuania</option> <option value="LU">Luxembourg</option> <option value="MO">Macao</option> <option value="MK">Macedonia, the former Yugoslav Republic of</option> <option value="MG">Madagascar</option> <option value="MW">Malawi</option> <option value="MY">Malaysia</option> <option value="MV">Maldives</option> <option value="ML">Mali</option> <option value="MT">Malta</option> <option value="MH">Marshall Islands</option> <option value="MQ">Martinique</option> <option value="MR">Mauritania</option> <option value="MU">Mauritius</option> <option value="YT">Mayotte</option> <option value="MX">Mexico</option> <option value="FM">Micronesia, Federated States of</option> <option value="MD">Moldova, Republic of</option> <option value="MC">Monaco</option> <option value="MN">Mongolia</option> <option value="ME">Montenegro</option> <option value="MS">Montserrat</option> <option value="MA">Morocco</option> <option value="MZ">Mozambique</option> <option value="MM">Myanmar</option> <option value="NA">Namibia</option> <option value="NR">Nauru</option> <option value="NP">Nepal</option> <option value="NL">Netherlands</option> <option value="NC">New Caledonia</option> <option value="NZ">New Zealand</option> <option value="NI">Nicaragua</option> <option value="NE">Niger</option> <option value="NG">Nigeria</option> <option value="NU">Niue</option> <option value="NF">Norfolk Island</option> <option value="MP">Northern Mariana Islands</option> <option value="NO">Norway</option> <option value="OM">Oman</option> <option value="PK">Pakistan</option> <option value="PW">Palau</option> <option value="PS">Palestinian Territory, Occupied</option> <option value="PA">Panama</option> <option value="PG">Papua New Guinea</option> <option value="PY">Paraguay</option> <option value="PE">Peru</option> <option value="PH">Philippines</option> <option value="PN">Pitcairn</option> <option value="PL">Poland</option> <option value="PT">Portugal</option> <option value="PR">Puerto Rico</option> <option value="QA">Qatar</option> <option value="RE">Réunion</option> <option value="RO">Romania</option> <option value="RU">Russian Federation</option> <option value="RW">Rwanda</option> <option value="BL">Saint Barthélemy</option> <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option> <option value="KN">Saint Kitts and Nevis</option> <option value="LC">Saint Lucia</option> <option value="MF">Saint Martin (French part)</option> <option value="PM">Saint Pierre and Miquelon</option> <option value="VC">Saint Vincent and the Grenadines</option> <option value="WS">Samoa</option> <option value="SM">San Marino</option> <option value="ST">Sao Tome and Principe</option> <option value="SA">Saudi Arabia</option> <option value="SN">Senegal</option> <option value="RS">Serbia</option> <option value="SC">Seychelles</option> <option value="SL">Sierra Leone</option> <option value="SG">Singapore</option> <option value="SX">Sint Maarten (Dutch part)</option> <option value="SK">Slovakia</option> <option value="SI">Slovenia</option> <option value="SB">Solomon Islands</option> <option value="SO">Somalia</option> <option value="ZA">South Africa</option> <option value="GS">South Georgia and the South Sandwich Islands</option> <option value="SS">South Sudan</option> <option value="ES">Spain</option> <option value="LK">Sri Lanka</option> <option value="SD">Sudan</option> <option value="SR">Suriname</option> <option value="SJ">Svalbard and Jan Mayen</option> <option value="SZ">Swaziland</option> <option value="SE">Sweden</option> <option value="CH">Switzerland</option> <option value="SY">Syrian Arab Republic</option> <option value="TW">Taiwan, Province of China</option> <option value="TJ">Tajikistan</option> <option value="TZ">Tanzania, United Republic of</option> <option value="TH">Thailand</option> <option value="TL">Timor-Leste</option> <option value="TG">Togo</option> <option value="TK">Tokelau</option> <option value="TO">Tonga</option> <option value="TT">Trinidad and Tobago</option> <option value="TN">Tunisia</option> <option value="TR">Turkey</option> <option value="TM">Turkmenistan</option> <option value="TC">Turks and Caicos Islands</option> <option value="TV">Tuvalu</option> <option value="UG">Uganda</option> <option value="UA">Ukraine</option> <option value="AE">United Arab Emirates</option> <option value="GB">United Kingdom</option> <option value="US">United States</option> <option value="UM">United States Minor Outlying Islands</option> <option value="UY">Uruguay</option> <option value="UZ">Uzbekistan</option> <option value="VU">Vanuatu</option> <option value="VE">Venezuela, Bolivarian Republic of</option> <option value="VN">Viet Nam</option> <option value="VG">Virgin Islands, British</option> <option value="VI">Virgin Islands, U.S.</option> <option value="WF">Wallis and Futuna</option> <option value="EH">Western Sahara</option> <option value="YE">Yemen</option> <option value="ZM">Zambia</option> <option value="ZW">Zimbabwe</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Flows</label>
                                        <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                            <option>International Trade</option>
                                            <option>Domestic</option>
                                            <option>Inbound</option>
                                            <option>Last Mille</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Transport Mode</label>
                                        <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                            <option>Road</option>
                                            <option>Maritime</option>
                                            <option>Air</option>
                                            <option>Train</option>
                                            <option>Fluvial</option>
                                            <option>Others</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Transport Type</label>
                                        <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                            <option>FTL</option>
                                            <option>LTL</option>
                                            <option>Parcel</option>
                                            <option>Others</option>
                                        </select>
                                    </div>

                                    <br>

                                    <h4>1.3. Timeline</h4>
                                    <br>

                                    <label for="exampleFormControlSelect1">Tentative date for project set - up completion</label>
                                    <div class="input-group date datepicker" id="datePicker1">
                                        <input type="text" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>


                                    <label for="exampleFormControlSelect1">Tentative date for Value Enablers completion</label>
                                    <div class="input-group date datepicker" id="datePicker2">
                                        <input type="text" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>


                                    <label for="exampleFormControlSelect1">Tentative date for Vendor Response completion</label>
                                    <div class="input-group date datepicker" id="datePicker3">
                                        <input type="text" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>


                                    <label for="exampleFormControlSelect1">Tentative date for Analytics completion</label>
                                    <div class="input-group date datepicker" id="datePicker4">
                                        <input type="text" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>


                                    <label for="exampleFormControlSelect1">Tentative date fot Conclusions & Recomendations completion</label>
                                    <div class="input-group date datepicker" id="datePicker5">
                                        <input type="text" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>


                                    <br>

                                    <h4>1.4. Solution Type</h4>
                                    <br>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Business Process Level 1</label>
                                        <select class="form-control" id="exampleFormControlSelect1" required>
                                            <option selected="" disabled="">Please select your Transport Mode</option>
                                            <option>Transport </option>
                                            <option>Planning</option>
                                            <option>Manufacturing</option>
                                            <option>Warehousing</option>
                                            <option>Sourcing</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Business Process Level 2</label>
                                        <select class="js-example-basic-multiple w-100" multiple="multiple" required>
                                            <option>Logistics Procurement</option>
                                            <option>Tactical Planning</option>
                                            <option>Order Management</option>
                                            <option>Transport Planning</option>
                                            <option>Tendering & Spot buying</option>
                                            <option>Execution & Visbility</option>
                                            <option>Document management</option>
                                            <option>Trade complaince</option>
                                            <option>FBA</option>
                                            <option>Reporting and Analytics </option>
                                        </select>

                                    </div>
                                </section>

                                <h2>RFP Upload</h2>
                                <section>
                                    <h4>2.1 Upload your RFP</h4>
                                    <br>
                                    <div class="form-group">
                                        <label>Upload your RFP</label>

                                        <div class="form-group">
                                            <form action="/file-upload" class="dropzone" id="exampleDropzone" name="exampleDropzone">
                                            </form>
                                        </div>

                                    </div>
                                </section>

                                <h2>Sizing Info</h2>
                                <section>
                                    <h4>3.1. Sizing Info</h4>
                                    <br>
                                    <div class="form-group">
                                        <label for="exampleInputText1">Annual # shipments
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="Annual # shipments">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">Average number of shimpments per month valley season
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="Average number of shimpments per month valley season">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputText1">Average number of shimpments per month peak season
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="Average number of shimpments per month peak season">
                                    </div>

                                    <div class="form-group">
                                        <label>Countries</label><br>
                                        <select class="js-example-basic-multiple w-100" multiple="multiple" required style="width: 100%;">
                                            <option value="AF">Afghanistan</option> <option value="AL">Albania</option> <option value="DZ">Algeria</option> <option value="AS">American Samoa</option> <option value="AD">Andorra</option> <option value="AO">Angola</option> <option value="AI">Anguilla</option> <option value="AQ">Antarctica</option> <option value="AG">Antigua and Barbuda</option> <option value="AR">Argentina</option> <option value="AM">Armenia</option> <option value="AW">Aruba</option> <option value="AU">Australia</option> <option value="AT">Austria</option> <option value="AZ">Azerbaijan</option> <option value="BS">Bahamas</option> <option value="BH">Bahrain</option> <option value="BD">Bangladesh</option> <option value="BB">Barbados</option> <option value="BY">Belarus</option> <option value="BE">Belgium</option> <option value="BZ">Belize</option> <option value="BJ">Benin</option> <option value="BM">Bermuda</option> <option value="BT">Bhutan</option> <option value="BO">Bolivia, Plurinational State of</option> <option value="BQ">Bonaire, Sint Eustatius and Saba</option> <option value="BA">Bosnia and Herzegovina</option> <option value="BW">Botswana</option> <option value="BV">Bouvet Island</option> <option value="BR">Brazil</option> <option value="IO">British Indian Ocean Territory</option> <option value="BN">Brunei Darussalam</option> <option value="BG">Bulgaria</option> <option value="BF">Burkina Faso</option> <option value="BI">Burundi</option> <option value="KH">Cambodia</option> <option value="CM">Cameroon</option> <option value="CA">Canada</option> <option value="CV">Cape Verde</option> <option value="KY">Cayman Islands</option> <option value="CF">Central African Republic</option> <option value="TD">Chad</option> <option value="CL">Chile</option> <option value="CN">China</option> <option value="CX">Christmas Island</option> <option value="CC">Cocos (Keeling) Islands</option> <option value="CO">Colombia</option> <option value="KM">Comoros</option> <option value="CG">Congo</option> <option value="CD">Congo, the Democratic Republic of the</option> <option value="CK">Cook Islands</option> <option value="CR">Costa Rica</option> <option value="CI">Côte d'Ivoire</option> <option value="HR">Croatia</option> <option value="CU">Cuba</option> <option value="CW">Curaçao</option> <option value="CY">Cyprus</option> <option value="CZ">Czech Republic</option> <option value="DK">Denmark</option> <option value="DJ">Djibouti</option> <option value="DM">Dominica</option> <option value="DO">Dominican Republic</option> <option value="EC">Ecuador</option> <option value="EG">Egypt</option> <option value="SV">El Salvador</option> <option value="GQ">Equatorial Guinea</option> <option value="ER">Eritrea</option> <option value="EE">Estonia</option> <option value="ET">Ethiopia</option> <option value="FK">Falkland Islands (Malvinas)</option> <option value="FO">Faroe Islands</option> <option value="FJ">Fiji</option> <option value="FI">Finland</option> <option value="FR">France</option> <option value="GF">French Guiana</option> <option value="PF">French Polynesia</option> <option value="TF">French Southern Territories</option> <option value="GA">Gabon</option> <option value="GM">Gambia</option> <option value="GE">Georgia</option> <option value="DE">Germany</option> <option value="GH">Ghana</option> <option value="GI">Gibraltar</option> <option value="GR">Greece</option> <option value="GL">Greenland</option> <option value="GD">Grenada</option> <option value="GP">Guadeloupe</option> <option value="GU">Guam</option> <option value="GT">Guatemala</option> <option value="GG">Guernsey</option> <option value="GN">Guinea</option> <option value="GW">Guinea-Bissau</option> <option value="GY">Guyana</option> <option value="HT">Haiti</option> <option value="HM">Heard Island and McDonald Islands</option> <option value="VA">Holy See (Vatican City State)</option> <option value="HN">Honduras</option> <option value="HK">Hong Kong</option> <option value="HU">Hungary</option> <option value="IS">Iceland</option> <option value="IN">India</option> <option value="ID">Indonesia</option> <option value="IR">Iran, Islamic Republic of</option> <option value="IQ">Iraq</option> <option value="IE">Ireland</option> <option value="IM">Isle of Man</option> <option value="IL">Israel</option> <option value="IT">Italy</option> <option value="JM">Jamaica</option> <option value="JP">Japan</option> <option value="JE">Jersey</option> <option value="JO">Jordan</option> <option value="KZ">Kazakhstan</option> <option value="KE">Kenya</option> <option value="KI">Kiribati</option> <option value="KP">Korea, Democratic People's Republic of</option> <option value="KR">Korea, Republic of</option> <option value="KW">Kuwait</option> <option value="KG">Kyrgyzstan</option> <option value="LA">Lao People's Democratic Republic</option> <option value="LV">Latvia</option> <option value="LB">Lebanon</option> <option value="LS">Lesotho</option> <option value="LR">Liberia</option> <option value="LY">Libya</option> <option value="LI">Liechtenstein</option> <option value="LT">Lithuania</option> <option value="LU">Luxembourg</option> <option value="MO">Macao</option> <option value="MK">Macedonia, the former Yugoslav Republic of</option> <option value="MG">Madagascar</option> <option value="MW">Malawi</option> <option value="MY">Malaysia</option> <option value="MV">Maldives</option> <option value="ML">Mali</option> <option value="MT">Malta</option> <option value="MH">Marshall Islands</option> <option value="MQ">Martinique</option> <option value="MR">Mauritania</option> <option value="MU">Mauritius</option> <option value="YT">Mayotte</option> <option value="MX">Mexico</option> <option value="FM">Micronesia, Federated States of</option> <option value="MD">Moldova, Republic of</option> <option value="MC">Monaco</option> <option value="MN">Mongolia</option> <option value="ME">Montenegro</option> <option value="MS">Montserrat</option> <option value="MA">Morocco</option> <option value="MZ">Mozambique</option> <option value="MM">Myanmar</option> <option value="NA">Namibia</option> <option value="NR">Nauru</option> <option value="NP">Nepal</option> <option value="NL">Netherlands</option> <option value="NC">New Caledonia</option> <option value="NZ">New Zealand</option> <option value="NI">Nicaragua</option> <option value="NE">Niger</option> <option value="NG">Nigeria</option> <option value="NU">Niue</option> <option value="NF">Norfolk Island</option> <option value="MP">Northern Mariana Islands</option> <option value="NO">Norway</option> <option value="OM">Oman</option> <option value="PK">Pakistan</option> <option value="PW">Palau</option> <option value="PS">Palestinian Territory, Occupied</option> <option value="PA">Panama</option> <option value="PG">Papua New Guinea</option> <option value="PY">Paraguay</option> <option value="PE">Peru</option> <option value="PH">Philippines</option> <option value="PN">Pitcairn</option> <option value="PL">Poland</option> <option value="PT">Portugal</option> <option value="PR">Puerto Rico</option> <option value="QA">Qatar</option> <option value="RE">Réunion</option> <option value="RO">Romania</option> <option value="RU">Russian Federation</option> <option value="RW">Rwanda</option> <option value="BL">Saint Barthélemy</option> <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option> <option value="KN">Saint Kitts and Nevis</option> <option value="LC">Saint Lucia</option> <option value="MF">Saint Martin (French part)</option> <option value="PM">Saint Pierre and Miquelon</option> <option value="VC">Saint Vincent and the Grenadines</option> <option value="WS">Samoa</option> <option value="SM">San Marino</option> <option value="ST">Sao Tome and Principe</option> <option value="SA">Saudi Arabia</option> <option value="SN">Senegal</option> <option value="RS">Serbia</option> <option value="SC">Seychelles</option> <option value="SL">Sierra Leone</option> <option value="SG">Singapore</option> <option value="SX">Sint Maarten (Dutch part)</option> <option value="SK">Slovakia</option> <option value="SI">Slovenia</option> <option value="SB">Solomon Islands</option> <option value="SO">Somalia</option> <option value="ZA">South Africa</option> <option value="GS">South Georgia and the South Sandwich Islands</option> <option value="SS">South Sudan</option> <option value="ES">Spain</option> <option value="LK">Sri Lanka</option> <option value="SD">Sudan</option> <option value="SR">Suriname</option> <option value="SJ">Svalbard and Jan Mayen</option> <option value="SZ">Swaziland</option> <option value="SE">Sweden</option> <option value="CH">Switzerland</option> <option value="SY">Syrian Arab Republic</option> <option value="TW">Taiwan, Province of China</option> <option value="TJ">Tajikistan</option> <option value="TZ">Tanzania, United Republic of</option> <option value="TH">Thailand</option> <option value="TL">Timor-Leste</option> <option value="TG">Togo</option> <option value="TK">Tokelau</option> <option value="TO">Tonga</option> <option value="TT">Trinidad and Tobago</option> <option value="TN">Tunisia</option> <option value="TR">Turkey</option> <option value="TM">Turkmenistan</option> <option value="TC">Turks and Caicos Islands</option> <option value="TV">Tuvalu</option> <option value="UG">Uganda</option> <option value="UA">Ukraine</option> <option value="AE">United Arab Emirates</option> <option value="GB">United Kingdom</option> <option value="US">United States</option> <option value="UM">United States Minor Outlying Islands</option> <option value="UY">Uruguay</option> <option value="UZ">Uzbekistan</option> <option value="VU">Vanuatu</option> <option value="VE">Venezuela, Bolivarian Republic of</option> <option value="VN">Viet Nam</option> <option value="VG">Virgin Islands, British</option> <option value="VI">Virgin Islands, U.S.</option> <option value="WF">Wallis and Futuna</option> <option value="EH">Western Sahara</option> <option value="YE">Yemen</option> <option value="ZM">Zambia</option> <option value="ZW">Zimbabwe</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputText1">Transport Spend
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="Transport Spend">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1"># Suppliers
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="# Suppliers">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1"># Plants
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="Plants">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1"># Warehouses
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="# Warehouses">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1"># Direct customers
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="# Direct customers">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1"># Final Clients
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="# Final Clients">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% Complex movements (different than OW)
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% Complex movements (different than OW)">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1"># carriers
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="# carriers">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% own fleet
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% own fleet">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% dedicated fleet
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% dedicated fleet">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% contracted fleet
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% contracted fleet">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% Road movements
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% Road movements">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% Maritime movements
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% Maritime movements">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% Air movements
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% Air movements">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% Rail movements
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% Rail movements">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% Fluvial movements
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% Fluvial movements">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% Intermodal movements
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% Intermodal movements">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% International
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% International">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% Domestic
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% Domestic">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% Inbound
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% Inbound">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% Last mile
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% Last mile">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">% FTL vs parcial
                                        </label>
                                        <input type="text" class="form-control" id="exampleInputText1" placeholder="% FTL vs parcial">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">Maximum number of concurrent users
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="Maximum number of concurrent users">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputText1">Number of named users
                                        </label>
                                        <input type="number" class="form-control" id="exampleInputText1" placeholder="Number of named users">
                                    </div>
                                </section>



                                <h2>Selection Criteria</h2>
                                <section>
                                    <h4>4.1. Fit Gap</h4>
                                    <br>
                                    Phasellus vehicula suscipit mauris, et aliquet urna. Fusce sed ipsum eu nunc pellentesque luctus. ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquam ornare sapien, ut dictum nunc pharetra a.Phasellus vehicula suscipit mauris, et aliquet urna. Fusce sed ipsum eu nunc pellentesque luctus. ipsum dolor sit amet.
                                    <br><br>
                                    <div style="text-align: center;">
                                        <button type="button" class="btn btn-primary btn-lg btn-icon-text" data-toggle="modal" data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square btn-icon-prepend"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg> Open Fit Gap table</button>

                                        <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Please complete the Fit Gap table</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <iframe src="./assets/vendors_techadvisory/jexcel-3.6.1/doc.html" style="width: 100%; min-height: 600px; border: none;"></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary btn-lg btn-icon-text" data-toggle="modal" data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square btn-icon-prepend"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg> Done</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <br><br>
                                    <h4>4.2. Corporate</h4>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>ID</th>
                                                    <th>Question</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>1</th>
                                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</td>
                                                </tr>
                                                <tr>
                                                    <th>2</th>
                                                    <td>Donec sapien purus, mollis ut leo eget, sodales tincidunt elit. Vestibulum varius congue blandit. Vestibulum pulvinar volutpat ultrices?</td>
                                                </tr>
                                                <tr>
                                                    <th>3</th>
                                                    <td>Integer ornare feugiat libero, non consectetur odio imperdiet rutrum?</td>
                                                </tr>
                                                <tr>
                                                    <th>4</th>
                                                    <td>Phasellus non sagittis dolor. Duis in suscipit ante. Vestibulum eu consequat augue?</td>
                                                </tr>
                                                <tr>
                                                    <th>5</th>
                                                    <td>Vivamus semper magna ac nulla interdum, vitae placerat erat viverra?</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <br><br>
                                    <h4>4.3. Market presence</h4>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>ID</th>
                                                    <th>Question</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>1</th>
                                                    <td>Headquarters</td>
                                                </tr>
                                                <tr>
                                                    <th>2</th>
                                                    <td>Commercial Offices</td>
                                                </tr>
                                                <tr>
                                                    <th>3</th>
                                                    <td>Service Team Offices</td>
                                                </tr>
                                                <tr>
                                                    <th>4</th>
                                                    <td>Geographies with solution implementations</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>



                                    <br><br>
                                    <h4>4.4. Experience</h4>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>ID</th>
                                                    <th>Question</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>1</th>
                                                    <td>Industry Experience</td>
                                                </tr>
                                                <tr>
                                                    <th>2</th>
                                                    <td>List all active clients</td>
                                                </tr>
                                                <tr>
                                                    <th>3</th>
                                                    <td>List how many successful implementations you performed within last 4 years</td>
                                                </tr>
                                                <tr>
                                                    <th>4</th>
                                                    <td>Share 3 customer references for implementation with similar size & scope (same industry preferred)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>



                                    <br><br>
                                    <h4>4.5. IT Enablers</h4>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>ID</th>
                                                    <th>Question</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>1</th>
                                                    <td>List your IT Enablers</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>




                                    <br><br>
                                    <h4>4.6. Alliances</h4>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>ID</th>
                                                    <th>Question</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>1</th>
                                                    <td>Partnership 1</td>
                                                </tr>
                                                <tr>
                                                    <th>2</th>
                                                    <td>Partnership 2</td>
                                                </tr>
                                                <tr>
                                                    <th>3</th>
                                                    <td>Partnership 3</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                    <br><br>
                                    <h4>4.7. Product</h4>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>ID</th>
                                                    <th>Question</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>1</th>
                                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</td>
                                                </tr>
                                                <tr>
                                                    <th>2</th>
                                                    <td>Donec sapien purus, mollis ut leo eget, sodales tincidunt elit. Vestibulum varius congue blandit. Vestibulum pulvinar volutpat ultrices?</td>
                                                </tr>
                                                <tr>
                                                    <th>3</th>
                                                    <td>Integer ornare feugiat libero, non consectetur odio imperdiet rutrum?</td>
                                                </tr>
                                                <tr>
                                                    <th>4</th>
                                                    <td>Phasellus non sagittis dolor. Duis in suscipit ante. Vestibulum eu consequat augue?</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <br><br>
                                    <h4>4.8. Sustainability</h4>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>ID</th>
                                                    <th>Question</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>1</th>
                                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</td>
                                                </tr>
                                                <tr>
                                                    <th>2</th>
                                                    <td>Donec sapien purus, mollis ut leo eget, sodales tincidunt elit. Vestibulum varius congue blandit. Vestibulum pulvinar volutpat ultrices?</td>
                                                </tr>
                                                <tr>
                                                    <th>3</th>
                                                    <td>Integer ornare feugiat libero, non consectetur odio imperdiet rutrum?</td>
                                                </tr>
                                                <tr>
                                                    <th>4</th>
                                                    <td>Phasellus non sagittis dolor. Duis in suscipit ante. Vestibulum eu consequat augue?</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                    <br><br>
                                    <h4>4.9. Implementation</h4>
                                    <br>
                                    <h6>Deliverables per phase</h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Phase</th>
                                                    <th>Deliverables</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <br>
                                    <h6>RACI Matrix</h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Task</th>
                                                    <th>Client</th>
                                                    <th>Vendor</th>
                                                    <th>Accenture</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>


                                    <br>
                                    <h6>Implementation Cost</h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Staffing Cost</th>
                                                    <th>Role</th>
                                                    <th>Estimated number of hours</th>
                                                    <th>Hourly rate</th>
                                                    <th>Staffing Cost</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <br>

                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Travel Cost</th>
                                                    <th>Month</th>
                                                    <th>Monthly Travel Cost</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <br>

                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Additional Cost</th>
                                                    <th>Item</th>
                                                    <th>Cost</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>


                                    <br><br>
                                    <h4>4.10. Run</h4>
                                    <br>
                                    <h6>Pricing Model</h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <br>
                                    <h6>Estimate first 5 years billing plan</h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Yearly cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Year 0 (Total Implementation Cost)</th>
                                                </tr><tr>
                                                    <td>Year 1</td>
                                                </tr><tr>
                                                    <td>Year 2</td>
                                                </tr><tr>
                                                    <td>Year 3</td>
                                                </tr><tr>
                                                    <td>Year 4</td>
                                                </tr><tr>
                                                    <td>Year 5</td>
                                                </tr><tr>
                                                    <td>Total cost</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <br><br>
                                    <h4>4.11. Scoring Criteria</h4>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Selection Criteria</th>
                                                    <th>Year Cost Vendor</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                <tr>
                                                    <td>1. Fitgap</td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="%">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>2. Vendor</td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="%">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>3. Experience</td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="%">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>4. Innovation & Vision</td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="%">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>5. Implementation & Commercials</td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="%">
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
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
