<?php

$app = Dofthings\App\Main::getInstance();
$e   = $app->getEnvSettings();

//check for maintenace mode
if ($e->maint_mode) {
    if (!isset($_SESSION["admin"])) {
        if ('login.php' !== curPageName()) {
            die("<h1>The System is undergoing maintenance. <a href=\"login.php\">Admin Login</a></h1>");
        }
    }
}

//set define for template used throughout the site and setup base url
DEFINE("TEMPLATE_DIR", "$e->template");
DEFINE("FORCE_COMPILE_ENABLED", "$e->force_compile_enabled");
DEFINE("DOT_SERVER_PATH", "http://" . $_SERVER['SERVER_NAME'] . "" . safeDir($_SERVER['PHP_SELF']) . "/");

DEFINE("SITE_VER", "v0.1");

DEFINE("DOCUMENT_CHARSET", "utf-8");

// sets the main image width
DEFINE("MAIN_IMAGE_WIDTH", "$e->main_image_width");

DEFINE("GITHUB_SITE_URL", "http://github.com/nayobix/d-of-things");
DEFINE("GITHUB_SITE_NAME", "d-of-Things");
DEFINE("SITE_VHOST", "$e->site_vhost");
DEFINE("SITE_URL", "$e->site_url" . "$e->site_vhost");
DEFINE("SITE_NAME", "$e->site_name");
DEFINE("SITE_LANGUAGE", "$e->site_lang");
DEFINE("DESCRIPTION", "$e->description");
DEFINE("HOME_DESCRIPTION_H1", "d-of-Things");
DEFINE("HOME_DESCRIPTION_H2", "Build. Measure. Store. Visualize. Notify");
DEFINE("HOME_DESCRIPTION_H3", "d-of-Things is Open");

DEFINE("KEYWORDS", "$e->keywords");
DEFINE("BACK_TO_LOGIN", "Back to login page.");

// define the header welcome message for different pages
DEFINE("HEADER_WELCOME_MESSAGE", "d-of-Things - Dashboard for the Internet of Things");
DEFINE("GOOGLE_SITE_VERIFICATION", "$e->google_code");

// Global form definitions
DEFINE("EMAIL", "Your Email*:");
DEFINE("USERNAME", "Username*:");
DEFINE("PASSWORD", "Password*:");
DEFINE("FIRST_NAME", "First Name*:");
DEFINE("LAST_NAME", "Last Name*:");
DEFINE("NAME", "Name*:");
DEFINE("COMPANY_NAME", "Company:");
DEFINE("PHONE", "Phone*:");

// define Menu Strings
DEFINE("MENU0", "Admin");

DEFINE("MENU1", "Dashboards");
DEFINE("MENU2", "Demo");
DEFINE("MENU3", "About");
DEFINE("MENU4", "Contact");
DEFINE("MENU5", "Console");
// <i class="menu-icon icon-wrench"></i>
DEFINE("SUBMENU1_MENU5", "Feeds");
DEFINE("SUBMENU2_MENU5", "Keys");
DEFINE("SUBMENU3_MENU5", "Alarms");

DEFINE("MENU6", "Keys");
// <i class="menu-icon icon-key"></i>

DEFINE("MENU7", "Logout");
// <i class="menu-icon icon-enter"></i>

DEFINE("MENU8", "Profile");
// <i class="menu-icon icon-cog"></i>

DEFINE("MENU9", "Settings");
DEFINE("MENU10", "Users");

// Header Navigation links
DEFINE("HEADER_NAV_LINK_LOGIN", "Login");
DEFINE("HEADER_NAV_LINK_SIGNUP", "Sign Up");
DEFINE("HEADER_NAV_LINK_SEARCH", "Search");

// Header writings
DEFINE("HEADER_NAV_PROFILE_IMAGE_TEXT", "The user profile picture.");

// Home page writings
DEFINE("ACCESSORY_LEAD", "");
DEFINE("HOME_SIGNUP", "Sign up!");

// Login page
DEFINE("LOGIN_LEAD", "In order to use d-of-Things to manage your devices you will need to have Javascript enabled.");
DEFINE("LOGIN_COLOR_ALERT", "Please re-enable Javascript for dofthings.org and try logging in again.");
DEFINE("LOGIN_LEAD2", "In order to use d-of-Things to manage your devices you will
	          need to use Internet Explorer version 10 or above. Alternatively,
		           recent versions of Chrome, Safari and Firefox work well.");
DEFINE("HEADER_NAV_LOGIN_FAIL", "Sorry, you entered an invalid username or password");
DEFINE("ACCOUNT_VALIDATION_SUCCESS","Your account was successfully activated. You may now login below");
DEFINE("INVALID_CONFIRMATION_ID_ERROR","The supplied onfirmation code - ".@$_GET["verify"]." - is not a valid confirmation code!");
DEFINE("USER_ALREADY_ACTIVATED","The username you are trying to activate has been activated!  Please login with this username!");
DEFINE("USER_ALREADY_EXIST_ERROR","This user already exists on the system. Please re-register at the <a href=\"register.php\">Registration Page</a> with another username.");
DEFINE("INVALID_TIMESTAMP_ERROR","The timestamp does not match with our records!");
DEFINE("INVALID_USER_ID_ERROR","You have tried to validate an invalid account!");

// Login form
DEFINE("FORMS_LOGIN", "Login");
DEFINE("FORMS_PASSWORD", "Password");
DEFINE("FORMS_FORGOT_PASSWORD", "Forgot Password");
DEFINE("FORMS_NO_ACCOUNT", "Don't have an account? ");
DEFINE("FORMS_SIGN_HERE", "Sign up here");
DEFINE("FORMS_REMEMBER_ME", " Remember me");
DEFINE("LOGIN_ERROR", "Login error!");
DEFINE("BLANK_USERNAME", "Username empty");

// Profile page
DEFINE("PROFILE", "Profile");
DEFINE("PROFILE_MSG1", "Profile");
DEFINE("PROFILE_MSG2", "Edit your profile");
DEFINE("PROFILE_FORMS_ID", "ID");
DEFINE("PROFILE_REG_DATE", "Registered on");
DEFINE("PROFILE_LAST_ACTIVE", "Last active");
DEFINE("PROFILE_FORMS_PASS", "Password");
DEFINE("PROFILE_FORMS_PASS_DESC", "Change your password!");
DEFINE("PROFILE_FORMS_EMAIL", "Email");
DEFINE("PROFILE_FORMS_EMAIL_DESC", "Input your email");
DEFINE("PROFILE_FORMS_FNAME", "First name");
DEFINE("PROFILE_FORMS_FNAME_DESC", "Input your first name");
DEFINE("PROFILE_FORMS_LNAME", "Last name");
DEFINE("PROFILE_FORMS_LNAME_DESC", "Input your last name");
DEFINE("PROFILE_FORMS_PHONE", "Phone");
DEFINE("PROFILE_FORMS_PHONE_DESC", "Input your phone");
DEFINE("PROFILE_FORMS_ADDRESS", "Address");
DEFINE("PROFILE_FORMS_ADDRESS_DESC", "Input your address");
DEFINE("PROFILE_FORMS_CITY", "City");
DEFINE("PROFILE_FORMS_CITY_DESC", "Input your city");
DEFINE("PROFILE_FORMS_NOTES", "Notes");
DEFINE("PROFILE_FORMS_NOTES_DESC", "Input your user notes");
DEFINE("PROFILE_FORMS_IMAGE", "Profile Image");
DEFINE("PROFILE_FORMS_IMAGE_DESC", "Input your user image url");
DEFINE("PROFILE_FORMS_UPDATE", "UPDATE");
DEFINE("PROFILE_UPDATE_MSG_OK", "Profile updated succesfully");
DEFINE("PROFILE_UPDATE_MSG_FAIL", "Profile update failed");

// Settings page
DEFINE("SETTINGS", "Settings");
DEFINE("SETTINGS_MSG1", "Settings");
DEFINE("SETTINGS_MSG2", "Edit env settings");
DEFINE("SETTINGS_FORMS_SITE", "Site URL");
DEFINE("SETTINGS_FORMS_SITE_DESC", "Site Url");
DEFINE("SETTINGS_FORMS_VHOST", "Virtual host");
DEFINE("SETTINGS_FORMS_VHOST_DESC", "");
DEFINE("SETTINGS_FORMS_ANAME", "Admin name");
DEFINE("SETTINGS_FORMS_ANAME_DESC", "");
DEFINE("SETTINGS_FORMS_AEMAIL", "Admin email");
DEFINE("SETTINGS_FORMS_AEMAIL_DESC", "");
DEFINE("SETTINGS_FORMS_SITE_MODE", "Site mode");
DEFINE("SETTINGS_FORMS_SITE_MODE_DESC", "Singleuser");
DEFINE("SETTINGS_FORMS_SITE_NAME", "Site name");
DEFINE("SETTINGS_FORMS_SITE_NAME_DESC", "");
DEFINE("SETTINGS_FORMS_DESCRIPTION", "Site description");
DEFINE("SETTINGS_FORMS_DESCRIPTION_DESC", "");
DEFINE("SETTINGS_FORMS_KEYWORDS", "Site keywords");
DEFINE("SETTINGS_FORMS_KEYWORDS_DESC", "");
DEFINE("SETTINGS_FORMS_SITE_LANG", "Site language");
DEFINE("SETTINGS_FORMS_SITE_LANG_DESC", "");
DEFINE("SETTINGS_FORMS_TEMPLATE", "Site template");
DEFINE("SETTINGS_FORMS_TEMPLATE_DESC", "");
DEFINE("SETTINGS_FORMS_USERS_DELETE", "Delete days");
DEFINE("SETTINGS_FORMS_USERS_DELETE_DESC", "Delete users after days");
DEFINE("SETTINGS_FORMS_EMAIL_DAYS", "Email days");
DEFINE("SETTINGS_FORMS_EMAIL_DAYS_DESC", "Email to users after days");
DEFINE("SETTINGS_FORMS_GOOGLE_CODE", "Google code");
DEFINE("SETTINGS_FORMS_GOOGLE_CODE_DESC", "Webmaster tools code");
DEFINE("SETTINGS_FORMS_CRON", "Cron Key");
DEFINE("SETTINGS_FORMS_CRON_DESC", "");
DEFINE("SETTINGS_FORMS_XMPP", "XMPP Settings");
DEFINE("SETTINGS_FORMS_XMPP_DESC", "");
DEFINE("SETTINGS_FORMS_XMPP_SERVER", "Server");
DEFINE("SETTINGS_FORMS_XMPP_PORT", "Port");
DEFINE("SETTINGS_FORMS_XMPP_USER", "Username");
DEFINE("SETTINGS_FORMS_XMPP_PASS", "Password");
DEFINE("SETTINGS_FORMS_XMPP_DOMAIN", "Domain");
DEFINE("SETTINGS_FORMS_XMPP_TEXT", "Text");
DEFINE("SETTINGS_FORMS_OTHERCRED", "Other Credentials");
DEFINE("SETTINGS_FORMS_OTHERCRED_DESC", "In JSON format");
DEFINE("SETTINGS_FORMS_SMTP", "SMTP Settings");
DEFINE("SETTINGS_FORMS_SMTP_DESC", "");
DEFINE("SETTINGS_FORMS_SMTP_SERVER", "Server");
DEFINE("SETTINGS_FORMS_SMTP_PORT", "Port");
DEFINE("SETTINGS_FORMS_SMTP_USER", "Username");
DEFINE("SETTINGS_FORMS_SMTP_PASS", "Password");
DEFINE("SETTINGS_FORMS_USE_VERIFY_EMAIL", "Verification");
DEFINE("SETTINGS_FORMS_USE_VERIFY_EMAIL_DESC", "Send mail to verify them");
DEFINE("SETTINGS_FORMS_VISITOR_TRACK", "Tracking");
DEFINE("SETTINGS_FORMS_VISITOR_TRACK_DESC", "Visitor tracking");
DEFINE("SETTINGS_FORMS_FORCE_COMPILE", "Force compile");
DEFINE("SETTINGS_FORMS_FORCE_COMPILE_DESC", "Site compilation");
DEFINE("SETTINGS_FORMS_FANCY", "Fancy urls");
DEFINE("SETTINGS_FORMS_FANCY_DESC", "Use fancy urls");
DEFINE("SETTINGS_FORMS_USER_APPROVAL", "Approval");
DEFINE("SETTINGS_FORMS_USER_APPROVAL_DESC", "User approval");
DEFINE("SETTINGS_FORMS_MAINT_MODE", "Maintanance");
DEFINE("SETTINGS_FORMS_MAINT_MODE_DESC", "Site maintanance");
DEFINE("SETTINGS_UPDATE_MSG_OK", "Settings updated succesfully");
DEFINE("SETTINGS_UPDATE_MSG_FAIL", "Settings update failed");
DEFINE("SETTINGS_FORMS_UPDATE", "UPDATE");

// Global Variables
DEFINE("SUBMIT", "SUMBIT");

// Users page
DEFINE("USERS", "Users");
DEFINE("USERS_MSG1", "Total users:");
DEFINE("USERS_MSG2", "Edit env settings");
DEFINE("USERS_FORMS_USERNAME", "Site url");
DEFINE("USERS_ID", "UID");
DEFINE("USERS_USER", "Username");
DEFINE("USERS_EMAIL", "Email");
DEFINE("USERS_FNAME", "First name");
DEFINE("USERS_LNAME", "Last name");
DEFINE("USERS_PHONE", "Phone");
DEFINE("USERS_ROLE", "Role");
DEFINE("USERS_EDIT", "Edit");
DEFINE("USERS_DELETE", "Delete");
DEFINE("USERS_DEACTIVATE", "Deactivate");
DEFINE("USERS_ACTIVATE", "Activate");
DEFINE("USERS_ACTION", "Action");
DEFINE("USERS_MAKEADMIN", "BeAdmin");
DEFINE("USERS_MAKEUSER", "BeUser");

// SignUp page
DEFINE("SIGNUP_FORMS_USERNAME", "Username *");
DEFINE("SIGNUP_FORMS_EMAIL", "Email *");
DEFINE("SIGNUP_FORMS_PASSWORD", "Password *");
DEFINE("SIGNUP_FORMS_USERNAME_DESC", "only letters, numbers, dots and underscores");
DEFINE("SIGNUP_FORMS_SIGN_DESC", "By signing up you agree to the");
DEFINE("SIGNUP_FORMS_SIGNUP", "SIGNUP");
DEFINE("REGISTRATION_SUCCESS", "You have successfully registered Your account. You may now <a href=\"login.php\" style=\"color:black\">login</a>.");
DEFINE("REGISTRATION_SUCCESS_VERIFY", "You have successfully registered Your account. Please verify your e-mail by clicking on the confirmation link sent to your e-mail. If you have not received it within the hour, please <a href=\"contact.php\">contact us</a>. After that, you may sign-in at the <a href=\"login.php\">Login Page</a>.");
DEFINE("ALREADY_EMAIL_ERROR", "You entered an invalid E-mail. Please try again");
DEFINE("VALIDATE_EMAIL_ERROR", "You must provide a valid E-mail. Please check your spelling and try again.");
DEFINE("ALREADY_USER_ERROR", "This username is already taken. Please select another username.");
DEFINE("VALIDATE_USER_ERROR", "Invalid username, usernames should contain _ letters a-z A-Z or numbers 0-9");

// Feeds page
DEFINE("FORMS_FEEDS_CREATE", "CREATE");
DEFINE("FORMS_FEEDS_UPDATE", "UPDATE");
DEFINE("FEEDS", "Feeds");
DEFINE("FEEDS_MSG1", "Create new feeds and push data to them");
DEFINE("FEEDS_MSG2", "Add New Feed");
DEFINE("FEEDS_MSG3", "Create Feed");
DEFINE("FEEDS_MSG4", "Edit Feed");
DEFINE("FEEDS_MSG5", "Edit existing feeds");
DEFINE("FEEDS_ID", "Feed ID");
DEFINE("FEEDS_TITLE", "Title");
DEFINE("FEEDS_ACTION", "Actions");
DEFINE("FEEDS_EDIT", "Edit");
DEFINE("FEEDS_DELETE", "Delete");
DEFINE("FEEDS_DEACTIVATE", "Deactivate");
DEFINE("FEEDS_ACTIVATE", "Activate");
DEFINE("FEEDS_LAST_UPDATE", "Last Update");
DEFINE("FEEDS_FORMS_NAME", "Name*");
DEFINE("FEEDS_FORMS_ID", "ID");
DEFINE("FEEDS_FORMS_ID_DESC", "Feed ID needed to push on the data");
DEFINE("FEEDS_FORMS_AUTO", "Auto");
DEFINE("FEEDS_FORMS_AUTO_DESC", "Update Feed initiated by the server or not");
DEFINE("FEEDS_FORMS_PARSER", "Parser");
DEFINE("FEEDS_FORMS_PARSER_DESC", "Define your parser string. Define which data to store. Use * for all data. Example:..........");
DEFINE("FEEDS_FORMS_SUBMIT", "Submit");
DEFINE("FEEDS_NEW_MSG_OK", "Feed successfully created. ID: ");
DEFINE("FEEDS_NEW_MSG_FAIL", "Please check Input fields, correct them and submit again");
DEFINE("FEEDS_DELETE_MSG_OK", "Feed successfully deleted");
DEFINE("FEEDS_DELETE_MSG_FAIL", "Feed is already deleted");
DEFINE("FEEDS_DEACTIVATE_MSG", "Feed successfully deactivated");
DEFINE("FEEDS_ACTIVATE_MSG", "Feed successfully activated");
DEFINE("FEEDS_UPDATE_MSG_OK", "Feed successfully updated");
DEFINE("FEEDS_FORMS_LOG", "Logging");
DEFINE("FEEDS_FORMS_LOG_DESC", "Remember last 100 rows of feed requests push/pull/execute");
DEFINE("FEEDS_LOG", "Log");
DEFINE("FEEDS_LOGID", "LogID");
DEFINE("FEEDS_LOGMSG", "Message");
DEFINE("FEEDS_LOGMSG1", "Logs");
DEFINE("FEEDS_LOGMSG2", "Logs from push/pull/execute requests per feed");
DEFINE("FEEDS_LOGDATE", "Time/Date");

// Alarms page
DEFINE("FORMS_ALARMS_CREATE", "CREATE");
DEFINE("FORMS_ALARMS_UPDATE", "UPDATE");
DEFINE("ALARMS", "Alarms");
DEFINE("ALARMS_MSG1", "Create new alarms");
DEFINE("ALARMS_MSG2", "Create Alarm");
DEFINE("ALARMS_MSG3", "Create Alarm");
DEFINE("ALARMS_MSG4", "Edit Alarm");
DEFINE("ALARMS_MSG5", "Populate the fields and submit at the bottom");
DEFINE("ALARMS_MSG6", "Edit the fields and submit at the bottom");
DEFINE("ALARMS_ID", "ID");
DEFINE("ALARMS_TYPE", "Type");
DEFINE("ALARMS_TITLE", "Title");
DEFINE("ALARMS_ACTION", "Actions");
DEFINE("ALARMS_EDIT", "Edit");
DEFINE("ALARMS_DELETE", "Delete");
DEFINE("ALARMS_DEACTIVATE", "Deactivate");
DEFINE("ALARMS_ACTIVATE", "Activate");
DEFINE("ALARMS_LAST_UPDATE", "Last Update");
DEFINE("ALARMS_FORMS_NAME", "Name&Description");
DEFINE("ALARMS_FORMS_ID", "ID");
DEFINE("ALARMS_FORMS_ID_DESC", "Alarm ID needed to push on the data");
DEFINE("ALARMS_FORMS_FEED", "Feed");
DEFINE("ALARMS_FORMS_FEED_DESC", "FeedID@FeedName@deviceID@deviceName@objectName");
DEFINE("ALARMS_FORMS_THRESHOLD", "Threshold");
DEFINE("ALARMS_FORMS_THRESHOLD_DESC", "Number or String");
DEFINE("ALARMS_FORMS_SIGN_DESC", "Comparison sign");
DEFINE("ALARMS_FORMS_NUMERIC", "Numeric");
DEFINE("ALARMS_FORMS_OPTIONS", "Options");
DEFINE("ALARMS_FORMS_LOGGING", "Logging");
DEFINE("ALARMS_FORMS_ACTIVE", "Active");
DEFINE("ALARMS_FORMS_RESET", "Alarm & Reset");
DEFINE("ALARMS_FORMS_RESET_DESC", "Reset immediately after alarm was generated. Looping the notifications");
DEFINE("ALARMS_FORMS_NOTIFICATION_TYPE", "Notification");
DEFINE("ALARMS_FORMS_NOTIFICATION_TYPE_DESC", "Type - Use between EMAIL/XMPP");
DEFINE("ALARMS_FORMS_NOTIFICATION_ADDRESS_DESC", "Email Address/URL");
DEFINE("ALARMS_FORMS_ACTION_TYPE", "Action");
DEFINE("ALARMS_FORMS_ACTION_TYPE_DESC", "Type - Use between URL/Local script");
DEFINE("ALARMS_FORMS_ACTION_ADDRESS_DESC", "Path");
DEFINE("ALARMS_FORMS_ACTION_VALUE_DESC", "Action value");
DEFINE("ALARMS_FORMS_CREDENTIALS", "Action credentials");
DEFINE("ALARMS_FORMS_USER_DESC", "Action username");
DEFINE("ALARMS_FORMS_PASS_DESC", "Action password");
DEFINE("ALARMS_FORMS_TIMETOALARM", "Time to alarm");
DEFINE("ALARMS_FORMS_TIMETOALARM_DESC", "Time in seconds. Default is 15 minutes = 900s");
DEFINE("ALARMS_FORMS_COUNTTOALARM", "Count to alarm");
DEFINE("ALARMS_FORMS_COUNTTOALARM_DESC", "Count. Default is 3 times");

DEFINE("ALARMS_FORMS_AUTO", "Auto");
DEFINE("ALARMS_FORMS_AUTO_DESC", "Update Alarm initiated by the server or not");
DEFINE("ALARMS_FORMS_PARSER", "Parser");
DEFINE("ALARMS_FORMS_PARSER_DESC", "Define your parser string. Define which data to store. Use * for all data. Example:..........");
DEFINE("ALARMS_FORMS_SUBMIT", "Submit");
DEFINE("ALARMS_NEW_MSG_OK", "Alarm successfully created");
DEFINE("ALARMS_NEW_MSG_FAIL", "Please check Input fields, correct them and submit again");
DEFINE("ALARMS_DELETE_MSG_OK", "Alarm successfully deleted");
DEFINE("ALARMS_DELETE_MSG_FAIL", "Alarm is already deleted");
DEFINE("ALARMS_DEACTIVATE_MSG", "Alarm successfully deactivated");
DEFINE("ALARMS_ACTIVATE_MSG", "Alarm successfully activated");
DEFINE("ALARMS_UPDATE_MSG_OK", "Alarm successfully updated");
DEFINE("ALARMS_UPDATE_MSG_FAIL", "Alarm update failed");
DEFINE("ALARMS_FORMS_LOG", "Logging");
DEFINE("ALARMS_FORMS_LOG_DESC", "Remember last 100 alarms");
DEFINE("ALARMS_LOG", "Log");
DEFINE("ALARMS_LOGMSG", "Message");
DEFINE("ALARMS_LOGMSG1", "Logs");
DEFINE("ALARMS_LOGMSG2", "Logs from alarms per alarm@metric");

DEFINE("ALARMS_LOGID", "ID");
DEFINE("ALARMS_ADDRESS", "Address");
DEFINE("ALARMS_SUBJECT", "Subject");
DEFINE("ALARMS_MESSAGE", "Message");
DEFINE("ALARMS_LOGDATE", "Last update");
DEFINE("ALARMS_PATH", "URL/Script Path");
DEFINE("ALARMS_ANSWER", "Answer");

// Keys page
DEFINE("FORMS_KEYS_CREATE", "CREATE");
DEFINE("FORMS_KEYS_UPDATE", "UPDATE");
DEFINE("KEYS", "Keys");
DEFINE("KEYS_MSG1", "Create keys of the feeds");
DEFINE("KEYS_MSG2", "Add New Key");
DEFINE("KEYS_MSG5", "Create new feed key");
DEFINE("KEYS_MSG6", "Edit existing key");
DEFINE("KEYS_LABEL", "Label");
DEFINE("KEYS_FEED_NAME", "Feed");
DEFINE("KEYS_ID", "Key ID");
DEFINE("KEYS_ACTION", "Actions");
DEFINE("KEYS_EDIT", "Edit");
DEFINE("KEYS_DELETE", "Delete");
DEFINE("KEYS_DEACTIVATE", "Deactivate");
DEFINE("KEYS_ACTIVATE", "Activate");
DEFINE("KEYS_LAST_UPDATE", "Last Update");
DEFINE("KEYS_FORMS_LABEL", "Label*");
DEFINE("KEYS_FORMS_FEED", "Feed*");
DEFINE("KEYS_FORMS_ID", "Key ID");
DEFINE("KEYS_FORMS_HASHID", "Key Hash");
DEFINE("KEYS_FORMS_ID_DESC", "Key ID needed to push on the data");
DEFINE("KEYS_FORMS_SUBMIT", "Submit");
DEFINE("KEYS_FORMS_PUSH_IP", "PUSH Source IP address");
DEFINE("KEYS_FORMS_PULL_IP", "PULL Source IP address");
DEFINE("KEYS_FORMS_EXECUTE_IP", "EXECUTE Source IP address");
DEFINE("KEYS_FORMS_FEED2", "Feed Name: ");
DEFINE("KEYS_FORMS_PUSH_IP_DESC", "IP address from which push requests will come. ALL for all IPs");
DEFINE("KEYS_FORMS_PULL_IP_DESC", "IP address from which pull requests will come. ALL for all IPs");
DEFINE("KEYS_FORMS_EXECUTE_IP_DESC", "IP address from which execute requests will come. ALL for all IPs");
DEFINE("KEYS_FORMS_PERMS", "Permissions");
DEFINE("KEYS_FORMS_PERMS_1", "Push");
DEFINE("KEYS_FORMS_PERMS_2", "Pull");
DEFINE("KEYS_FORMS_PERMS_3", "Execute");
DEFINE("KEYS_FORMS_PERMS_4", "Full");
DEFINE("KEYS_FORMS_ACTIVE", "Deactivate");
DEFINE("KEYS_FORMS_ACTIVE_DESC", "Disable the current Feed Key ID");
DEFINE("KEYS_DEACTIVATE_MSG", "Key successfully deactivated");
DEFINE("KEYS_ACTIVATE_MSG", "Key successfully activated");
DEFINE("KEYS_UPDATE_MSG_OK", "Key successfully updated");
DEFINE("KEYS_UPDATE_MSG_FAIL", "Alarm update failed");
DEFINE("KEYS_DELETE_MSG_OK", "Key successfully deleted");
DEFINE("KEYS_DELETE_MSG_FAIL", "Key is already deleted");
DEFINE("KEYS_NEW_MSG_OK", "Key successfully created");
DEFINE("KEYS_NEW_MSG_FAIL", "Please check Input fields, correct them and submit again");
DEFINE("KEYS_MSG4", "Edit Key");

// Dashboards page
DEFINE("DASHBOARDS", "Dashboards");
DEFINE("DASHBOARDS_MSG1", "Create new dashboard and add graphics/controls to it");
DEFINE("DASHBOARDS_MSG2", "Add New dashboard");
DEFINE("DASHBOARDS_MSG3", "Create Dashboard");
DEFINE("DASHBOARDS_MSG4", "Edit Dashboard");
DEFINE("DASHBOARDS_MSG5", "Edit existing dashboards");
DEFINE("DASHBOARDS_MSG6", "");
DEFINE("DASHBOARDS_ID", "Dashboard ID");
DEFINE("DASHBOARDS_TITLE", "Title");
DEFINE("DASHBOARDS_ACTION", "Actions");
DEFINE("DASHBOARDS_EDIT", "Edit");
DEFINE("DASHBOARDS_DELETE", "Delete");
DEFINE("DASHBOARDS_DEACTIVATE", "Deactivate");
DEFINE("DASHBOARDS_ACTIVATE", "Activate");
DEFINE("DASHBOARDS_LAST_UPDATE", "Last Update");
DEFINE("DASHBOARDS_NEW_MSG_OK", "Dashboard successfully created. ID: ");
DEFINE("DASHBOARDS_NEW_MSG_FAIL", "Please check Input fields, correct them and submit again");
DEFINE("DASHBOARDS_DELETE_MSG_OK", "Dashboard successfully deleted");
DEFINE("DASHBOARDS_DELETE_MSG_FAIL", "Dashboard is already deleted");
DEFINE("DASHBOARDS_DEACTIVATE_MSG", "Dashboard successfully deactivated");
DEFINE("DASHBOARDS_ACTIVATE_MSG", "Dashboard successfully activated");
DEFINE("DASHBOARDS_UPDATE_MSG_OK", "Dashboard successfully updated");
DEFINE("DASHBOARDS_VISUALIZE", "Dashboard view");

// About page
DEFINE("ABOUT", "About:");

// Contact page
DEFINE("CONTACT", "Contact: ");

// Emails
DEFINE("EMAIL_SIGNUP_SUBJECT","Welcome %USERNAME% your new account signup at %URL%");
DEFINE("EMAIL_SIGNUP_BODY","Your new account user name is %USERNAME%, and your password has been automaticly generated for you. <br />Your new password is %PASSWORD%. <br /><br />Please login at %URL%");
DEFINE("EMAIL_SIGNUP_BODY_VERIFY","Your new account user name is %USERNAME%, and your password has been automaticly generated for you. <br />Your new password is %PASSWORD%. <br /><br />Please verify your e-mail by clicking on this confirmation link %CONFIRMURL%. <br /><br />After that, please login at %URL%");
DEFINE("EMAIL_SIGNUP_BODY_WPASS","Your new account user name is %USERNAME%, and your password has been automatically generated for you. <br />Your new password is %PASSWORD%. <br /><br />Please login at %URL%");
DEFINE("EMAIL_SIGNUP_BODY_WPASS_VERIFY","Your new account user name is %USERNAME%. <br />Your new password is %PASSWORD%. <br /><br />Please verify your e-mail by clicking on this confirmation link %CONFIRMURL%  <br /><br />After that, please login at %URL%");

DEFINE("NO_JAVASCRIPT_ENABLED_ERROR", "JavaScript is turned off in your web browser. Turn it on to take full advantage of this site, then refresh the page.");
DEFINE("NO_DEFAULT_SELLER", "It appears you have not setup a default seller account, You can do so by going to the add user section of the admin page.");

// Footer page text
DEFINE("TOS", "Terms of Use");
DEFINE("PRIVACY", "Privacy Policy");
?>
