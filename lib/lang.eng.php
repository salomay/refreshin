<?php

/*******************************************************************************
* Filename : lang.eng.php
* Description : english language
*******************************************************************************/

## HTML ##
$app['lang']['html']['company'] = "PT SORINI AGRO ASIA Corporindo Tbk.";
$app['lang']['html']['title'] = "PT SORINI AGRO ASIA Corporindo Tbk.";
$app['lang']['html']['webmin_title'] = "".$app['lang']['html']['company']." Website Administration";

## KEYWORDS ##
$app['keywords'] = "";
$app['description'] = "";

## BUTTON ##
$app['lang']['button']['back'] = "<div align='center'><form><input type='button' value='Back' OnClick='history.back()' class='btn'></form></div>";
$app['lang']['button']['ok'] = "<div align='center'><form><input type='button' value='Ok' OnClick='set_action(this, 'home')' class='btn'><input type='hidden' name='act'></form></div>";
$app['lang']['button']['agree'] = "<div align='center'><form><input type='button' value='Ok' OnClick='set_action(this, 'agree')' class='btn'><input type='hidden' name='act'></form></div>";

## PAGINATION ##
$app['lang']['txt']['page'] = "Page";
$app['lang']['txt']['out_of'] = "out of";
$app['lang']['txt']['all'] = "ALL";


## ERROR COMPONENT ##
$app['lang']['error']['header'] = "<div class='msgStatusError'>The following error occured :<br>";
$app['lang']['error']['element'] = "<li>";
$app['lang']['error']['footer'] = "</div><hr size='1'>";
$app['lang']['error']['title'] = "Error...";

## ERROR TYPE ##
$app['lang']['error']['empty'] = "must be filled.";
$app['lang']['error']['digit'] = "must be digit.";
$app['lang']['error']['date'] = "must be a valid date.";
$app['lang']['error']['checkbox'] = "select at least one record.";
$app['lang']['error']['select'] = "must be selected.";
$app['lang']['error']['email'] = "must be a valid email address.";
$app['lang']['error']['invalid_login'] = "Invalid username or password.";
$app['lang']['error']['adm_not_login'] = "You're not loggin yet...<br><br>Please login <a href='$app[webmin]/index.php'>here</a>";
$app['lang']['error']['adm_no_permission'] = "Sorry you do not have permission to use this application.".$app['lang']['button']['back']."";
$app['lang']['error']['username_exist'] = "Username already exist. Please try another one.";
$app['lang']['error']['email_exist'] = "Sorry, your email has been subscribed. Please register with other email.";
$app['lang']['error']['password_not_match'] = "Please retype your new password correctly.";
$app['lang']['error']['one_application_required'] = "You must select at least one application for user.";
$app['lang']['error']['image.ERR_TYPE'] = "type error.";
$app['lang']['error']['image.ERR_WIDTH'] = "height and weight error.";
$app['lang']['error']['image.ERR_SIZE'] = "size error.";
$app['lang']['error']['ERR_COPY'] = "upload error.";
$app['lang']['error']['file.ERR_SIZE'] = "file size error.";
$app['lang']['error']['block_error_up'] = "block currently on the highest position.";
$app['lang']['error']['block_error_down'] = "block currently on the lowest position.";
$app['lang']['error']['member_not_login'] = "You're not loggin yet...<br><br>Please login <a href='$app[www]/internal/index.php'>here</a>";
$app['lang']['error']['char'] = "too much characters.";

$app['lang']['error']['company_id_exist'] = "ID Company already exist. Please try another one.";


## FIELD ##
$app['lang']['field']['name'] = "name";
$app['lang']['field']['to'] = "to";
$app['lang']['field']['username'] = "username";
$app['lang']['field']['password'] = "password";

$app['lang']['field']['table'] = "table name";
$app['lang']['field']['dashboard'] = "dashboard";
$app['lang']['field']['view'] = "view type";
$app['lang']['field']['column'] = "column";

$app['lang']['field']['title'] = "title";
$app['lang']['field']['title_eng'] = "title eng ";
$app['lang']['field']['title_ina'] = "title ina ";

$app['lang']['field']['cat'] = "category";
$app['lang']['field']['lead'] = "lead";
$app['lang']['field']['quote'] = "quote";
$app['lang']['field']['page'] = "page";
$app['lang']['field']['content'] = "content";
$app['lang']['field']['member'] = "member";
$app['lang']['field']['photographer'] = "photographer";
$app['lang']['field']['content_eng'] = "content eng ";
$app['lang']['field']['content_ina'] = "content ina ";
$app['lang']['field']['lead_eng'] = "lead eng ";
$app['lang']['field']['lead_ina'] = "lead ina ";
$app['lang']['field']['description'] = "description";
$app['lang']['field']['published_date'] = "published date";
$app['lang']['field']['thumb'] = "thumbnail";
$app['lang']['field']['pichome'] = "picture home";
$app['lang']['field']['pic'] = "picture";
$app['lang']['field']['time'] = "time";
$app['lang']['field']['date'] = "date";
$app['lang']['field']['file'] = "file";
$app['lang']['field']['reply'] = "reply";
$app['lang']['field']['email'] = "email";
$app['lang']['field']['link'] = "link";
$app['lang']['field']['comment'] = "comment";
$app['lang']['field']['subject'] = "subject";
$app['lang']['field']['purpose'] = "purpose";
$app['lang']['field']['contact_by'] = "contact by";
$app['lang']['field']['serial_gps'] = "serial number GPS";
$app['lang']['field']['repassword'] = "retype password";
$app['lang']['field']['code'] = "code";

$app['lang']['field']['history_description'] = "product description";
$app['lang']['field']['prodcat'] = "category product";
$app['lang']['field']['form'] = "form";
$app['lang']['field']['company_id'] = "ID company";
$app['lang']['field']['company'] = "company";
$app['lang']['field']['company_name'] = "company name";
$app['lang']['field']['company_address'] = "company address";
$app['lang']['field']['company_type'] = "company type";
$app['lang']['field']['fax'] = "fax";
$app['lang']['field']['address'] = "address";
$app['lang']['field']['city'] = "city";
$app['lang']['field']['state'] = "state";
$app['lang']['field']['zipcode'] = "zip code";
$app['lang']['field']['phone'] = "phone number";
$app['lang']['field']['comments'] = "comments";
$app['lang']['field']['message'] = "message";
$app['lang']['field']['features'] = "features";
$app['lang']['field']['purpose'] = "purpose";

$app['lang']['field']['question'] = "question";
$app['lang']['field']['answer'] = "answer";
$app['lang']['field']['nama'] = "nama";
$app['lang']['field']['modul'] = "modul";
$app['lang']['field']['tabel'] = "table";
$app['lang']['field']['dashboard'] = "dashboard";

$app['lang']['field']['client'] = "client";
$app['lang']['field']['category'] = "category";
$app['lang']['field']['name_video'] = "title";
$app['lang']['field']['gallery_cat'] = "category gallery";
$app['lang']['field']['name_gallery'] = "name gallery";


$app['lang']['field']['your_name'] = "Your Name";
$app['lang']['field']['your_email'] = "Your Email";

$app['lang']['field']['friend_name'] = "Your Friend Name";
$app['lang']['field']['friend_email'] = "Your Friend Email";

$app['lang']['field']['cust_id'] = "Customer";
$app['lang']['field']['msacCode'] = "Code";
$app['lang']['field']['msacShortName'] = "Short Name";
$app['lang']['field']['msacName'] = "Name";
$app['lang']['field']['msacAddress'] = "Address";
$app['lang']['field']['msacCity'] = "City";
$app['lang']['field']['msacPhone'] = "Phone";
$app['lang']['field']['msacCP'] = "Contact Person";
$app['lang']['field']['msacEmail'] = "Email";
$app['lang']['field']['msacPassword'] = "Password";

$app['lang']['field']['quantity'] = "Quantity";
$app['lang']['field']['order_code'] = "Order Code";
$app['lang']['field']['country'] = "Country";
$app['lang']['field']['kriteria'] = "Kriteria";
$app['lang']['field']['subject_type'] = "Subject Type";
$app['lang']['field']['inquiry'] = "Inquiry";
$app['lang']['field']['security_code'] = "Security Code";
$app['lang']['field']['tahun'] = "Tahun";

$app['lang']['field']['url'] = "URL";
$app['lang']['field']['keyword'] = "meta keyword";
## 'info' ##
$app['lang']['info']['header'] = "<div class='msgStatusSuccess'>";
$app['lang']['info']['footer'] = "</div><hr size='1'>";
$app['lang']['info']['adm_logout'] = "Admin has logout.";
$app['lang']['info']['member_logout'] = "Member has logout.";
$app['lang']['info']['member_logout'] = "Member has logout.";
$app['lang']['info']['user_added'] = "New user has been added to database.";
$app['lang']['info']['user_modified'] = "User has been modified.";
$app['lang']['info']['user_deleted'] = "Selected user has been deleted.";
$app['lang']['info']['user_status'] = "User status has been modified.";
$app['lang']['info']['password_modified'] = "Password User has been modified.";

$app['lang']['info']['header_title_added'] = "Header Title has been added to database.";
$app['lang']['info']['header_title_modified'] = "Header Title has been modified.";
$app['lang']['info']['header_title_deleted'] = "Header Title has been deleted.";
$app['lang']['info']['header_title_status'] = "Header Title status has been modified.";

$app['lang']['info']['header_image_added'] = "Header Image has been added to database.";
$app['lang']['info']['header_image_modified'] = "Header Image has been modified.";
$app['lang']['info']['header_image_deleted'] = "Header Image has been deleted.";
$app['lang']['info']['header_image_status'] = "Header Image status has been modified.";
$app['lang']['info']['header_image_moved'] = "Header Image has been moved.";

$app['lang']['info']['download_added'] = "Download has been added to database.";
$app['lang']['info']['download_modified'] = "Download has been modified.";
$app['lang']['info']['download_deleted'] = "Download has been deleted.";
$app['lang']['info']['download_status'] = "Download status has been modified.";
$app['lang']['info']['download_moved'] = "Download has been moved.";

$app['lang']['info']['dashboard_added'] = "Dashboard has been added to database.";
$app['lang']['info']['dashboard_modified'] = "Dashboard has been modified.";
$app['lang']['info']['dashboard_deleted'] = "Dashboard has been deleted.";
$app['lang']['info']['dashboard_status'] = "Dashboard status has been modified.";

$app['lang']['info']['product_added'] = "Product has been added to database.";
$app['lang']['info']['product_modified'] = "Product has been modified.";
$app['lang']['info']['product_deleted'] = "Product has been deleted.";
$app['lang']['info']['product_status'] = "Product status has been modified.";
$app['lang']['info']['product_moved'] = "Product  has been moved.";

$app['lang']['info']['productcat_added'] = "Category Product has been added to database.";
$app['lang']['info']['productcat_modified'] = "Category Product has been modified.";
$app['lang']['info']['productcat_deleted'] = "Category Product has been deleted.";
$app['lang']['info']['productcat_status'] = "Category Product status has been modified.";
$app['lang']['info']['productcat_moved'] = "Category Product has been moved.";

$app['lang']['info']['productdetil_added'] = "Product Detail has been added to database.";
$app['lang']['info']['productdetil_modified'] = "Product Detail has been modified.";
$app['lang']['info']['productdetil_deleted'] = "Product Detail has been deleted.";
$app['lang']['info']['productdetil_status'] = "Product Detail status has been modified.";
$app['lang']['info']['productdetil_moved'] = "Product Detail has been moved.";

$app['lang']['info']['snack_added'] = "Snack has been added to database.";
$app['lang']['info']['snack_modified'] = "Snack has been modified.";
$app['lang']['info']['snack_deleted'] = "Snack has been deleted.";
$app['lang']['info']['snack_status'] = "Snack status has been modified.";

$app['lang']['info']['snack_cat_added'] = "Snack category has been added to database.";
$app['lang']['info']['snack_cat_modified'] = "Snack category has been modified.";
$app['lang']['info']['snack_cat_deleted'] = "Snack category has been deleted.";
$app['lang']['info']['snack_cat_status'] = "Snack category status has been modified.";

$app['lang']['info']['customer_added'] = "Customer Choice has been added to database.";
$app['lang']['info']['customer_modified'] = "Customer Choice has been modified.";
$app['lang']['info']['customer_deleted'] = "Customer Choice has been deleted.";
$app['lang']['info']['customer_status'] = "Customer Choice status has been modified.";

$app['lang']['info']['distribusi_added'] = "Customer Choice has been added to database.";
$app['lang']['info']['distribusi_modified'] = "Customer Choice has been modified.";
$app['lang']['info']['distribusi_deleted'] = "Customer Choice has been deleted.";
$app['lang']['info']['distribusi_status'] = "Customer Choice status has been modified.";

$app['lang']['info']['promo_added'] = "Promo has been added to database.";
$app['lang']['info']['promo_modified'] = "Promo has been modified.";
$app['lang']['info']['promo_cat_deleted'] = "Promo has been deleted.";
$app['lang']['info']['promo_status'] = "Promo status has been modified.";

$app['lang']['info']['page_added'] = "Page has been added to database.";
$app['lang']['info']['page_modified'] = "Page has been modified.";
$app['lang']['info']['page_deleted'] = "Page has been deleted.";
$app['lang']['info']['page_status'] = "Page status has been modified.";

$app['lang']['info']['faq_added'] = "FAQ has been added to database.";
$app['lang']['info']['faq_modified'] = "FAQ has been modified.";
$app['lang']['info']['faq_deleted'] = "FAQ has been deleted.";
$app['lang']['info']['faq_status'] = "FAQ status has been modified.";
$app['lang']['info']['faq_moved'] = "FAQ has been moved.";

$app['lang']['info']['contact_email_added'] = "Contact email has been added to database.";
$app['lang']['info']['contact_email_modified'] = "Contact email has been modified.";
$app['lang']['info']['contact_email_deleted'] = "Contact email has been deleted.";
$app['lang']['info']['contact_email_status'] = "Contact email status has been modified.";

$app['lang']['info']['configuration_modified'] = "Configuration has been modified.";
$app['lang']['info']['comment_sent'] = "Thank you!! Your reference spot has been sent.";
$app['lang']['info']['comment_sent_contact'] = "Thank you!! Your comment has been sent.";
$app['lang']['info']['registrasi_sent'] = "Thank you!! Your registration member has been sent.";

$app['lang']['info']['contact_forward'] = "Contact has been fowarded.";
$app['lang']['info']['contact_reply'] = "Contact has been replied.";
?>