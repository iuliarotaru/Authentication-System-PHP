<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/router.php");

// ##################################################
// ##################################################
// ##################################################

get('/', 'views/view_signup.php');
get('/admin', 'views/view_admin.php');
// get('/email', 'views/view_email.php');
get('/delete', 'bridges/bridge_delete_account.php');
get('/forgot-password', 'views/view_forgot_password.php');
get('/login', 'views/view_login.php');
get('/login/error/$display_message', 'views/view_login.php');
get('/logout', 'bridges/bridge_logout.php');
get('/profile', 'views/view_profile.php');
get('/signup/error/$display_message', 'views/view_signup.php');
get('/users', 'views/view_users.php');
get('/update', 'views/view_update.php');
get('/therapist', 'views/view_therapist.php');
get('/verify/$token', 'bridges/bridge_verify.php');
get('/verify-recover/$token', 'views/view_recover_password.php');
get('/verify-recover/$token/error/$display_message', 'views/view_recover_password.php');


// ##################################################
// ##################################################
// ##################################################

post('/create-users', 'db/create_users.php');
post('/create-password-recovery', 'db/create_password_recovery.php');
post('/create-user-role', 'db/create_user_role.php');
post('/login', 'bridges/bridge_login.php');
post('/forgot-password', 'bridges/bridge_forgot_password.php');
post('/seed-users', 'db/seed_users.php');
post('/signup', 'bridges/bridge_signup.php');
post('/recover-password', 'bridges/bridge_recover_password.php');
post('/update-profile', 'bridges/bridge_update.php');
post('/users/block/$user_id', 'apis/api_block_user.php');
// post('/verify-phone', '')

any('/404','views/view_404.php');