Things to be done
-----------------

1. Fork dmstr/yii2-adminlte-asset and break dependency from cebe/yii2-gravatar
2. Make use account avatars (adminlte has some pictures).
3. User profile page. +++
4. Console command for database backup. +++ (via sql console command)
5. Session messages (after logout, register and so on). +++
6. Global translation function t() wrapper for Yii::t(). +++
7. Wrapper for session->setFlash in base Controller. +++
8. New "Settings" tab in user profile with preferred language and timezone.
9. Option for enable/disable social login in user login action.

Features for 0.2 release:
1. Users management page (related with no.3). +++
2. Configuration editor (avoid of manual editing params in config/web.php). +++
3. Simple RBAC with "Administrator" and "Registered" roles.
4. Modal with remote content. +++
5. System log page.
6. User activation by email (levearage of 'Pending' status).

Features for 0.3 release:
1. Send email after registration:
    - email text
    - setting for enable/disable sending
    - add checkbox in admin user create form for sending email
2. Localization.
