<?php

return [

    // Laravel Authentication Messages
    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    // General Authentication
    'authentication_failed' => 'Authentication failed. Please try again.',
    'unauthorized' => 'You are not authorized to perform this action.',
    'session_expired' => 'Your session has expired. Please log in again.',
    'account_not_found' => 'Account not found.',
    'account_disabled' => 'Your account has been disabled.',
    'account_locked' => 'Your account is locked. Please try again later.',

    // Layout
    'layout' => [
        'logo' => 'Logo',
        'savings' => 'Savings',
        'loan' => 'Loans',
        'payment' => 'Payments',

        'secure_simple_management' => 'Secure and simple financial management',
        'welcome_back' => 'Welcome back!',
        'management_description' => 'Manage members, savings, loans, and payments securely in one place.',

        'manage_savings' => 'Manage savings',
        'manage_loans' => 'Manage loans',
        'track_payments' => 'Track payments',

        'secure' => 'Secure',
        'secure_account_access' => 'Secure account access',

        'all_rights_reserved' => 'All rights reserved.',

        'welcome' => 'Welcome',
        'manage_account' => 'Manage your account with ease.',
    ],

    // Login
    'login' => [
        'title' => 'Log in',
        'heading' => 'Log in to your account',
        'description' => 'Enter your email and password below to log in.',

        'email' => 'Email address',
        'email_placeholder' => 'Enter your email address',

        'password' => 'Password',
        'password_placeholder' => 'Enter your password',

        'forgot_password' => 'Forgot your password?',
        'remember_me' => 'Remember me',

        'login' => 'Log in',
        'logging_in' => 'Logging in...',

        'dont_have_account' => "Don't have an account?",
        'sign_up' => 'Sign up',

        'failed' => 'These credentials do not match our records.',
        'throttled' => 'Too many login attempts. Please try again in :seconds seconds.',
        'success' => 'Successfully logged in.',
    ],

    // Register
    'register' => [
        'title' => 'Register',
        'heading' => 'Create an account',
        'description' => 'Enter your details below to create your account.',

        'name' => 'Name',
        'name_placeholder' => 'Full name',

        'email' => 'Email address',
        'email_placeholder' => 'Enter your email address',

        'password' => 'Password',
        'password_placeholder' => 'Enter your password',

        'confirm_password' => 'Confirm password',
        'confirm_password_placeholder' => 'Enter your password again',

        'create_account' => 'Create account',
        'creating_account' => 'Creating account...',

        'already_have_account' => 'Already have an account?',
        'login' => 'Log in',

        'success' => 'Your account has been created successfully.',
        'failed' => 'Account registration failed. Please try again.',
    ],

    // Logout
    'logout' => [
        'button' => 'Log out',

        'confirm_title' => 'Log out of your account?',
        'confirm_text' => 'You will be logged out of this account.',
        'confirm_button' => 'Yes, log out',
        'cancel_button' => 'Cancel',

        'success' => 'You have been logged out successfully.',
    ],

    // Forgot Password
    'forgot_password' => [
        'title' => 'Forgot Password',
        'heading' => 'Forgot your password?',
        'description' => "No problem. Enter your email address and we'll send you a link to reset your password.",

        'email' => 'Email address',
        'email_placeholder' => 'Enter your email address',

        'send_reset_link' => 'Send password reset link',
        'sending' => 'Sending link...',

        'remember_password' => 'Remember your password?',
        'login' => 'Log in',

        'sent' => 'We have emailed your password reset link.',
        'failed' => 'We could not send the password reset link. Please try again.',
    ],

    // Reset Password
    'reset_password' => [
        'title' => 'Reset Password',
        'heading' => 'Create a new password',
        'description' => 'Enter your new password below. Make sure it is strong and secure.',

        'email' => 'Email address',
        'email_placeholder' => 'Enter your email address',

        'new_password' => 'New password',
        'new_password_placeholder' => 'Enter your new password',

        'confirm_password' => 'Confirm new password',
        'confirm_password_placeholder' => 'Enter your new password again',

        'reset_password' => 'Reset password',
        'resetting' => 'Resetting password...',

        'security_hint' => 'After resetting your password, you can use it to log in to your account.',

        'success' => 'Your password has been reset successfully.',
        'failed' => 'The password reset link is invalid or has expired.',
        'invalid_token' => 'The password reset token is invalid.',
        'expired' => 'The password reset link has expired.',
    ],

    // Confirm Password
    'confirm_password' => [
        'title' => 'Confirm Password',
        'heading' => 'Confirm your identity',
        'description' => 'This is a secure area of the application. Please confirm your identity before continuing.',

        'confirm_with_passkey' => 'Confirm with passkey',
        'confirming' => 'Confirming...',

        'or_confirm_with_password' => 'Or confirm with your password',

        'password' => 'Password',
        'password_placeholder' => 'Enter your password',

        'confirm' => 'Confirm password',

        'success' => 'Password confirmed successfully.',
        'failed' => 'The provided password is incorrect.',
    ],

    // Email Verification
    'email_verification' => [
        'title' => 'Email Verification',
        'heading' => 'Verify your email address',

        'description' => 'Please verify your email address by clicking the link we just sent to your inbox.',

        'verification_link_sent' => 'A new verification link has been sent to the email address you used when registering.',

        'resend_verification' => 'Resend verification email',
        'resending' => 'Resending...',

        'logout' => 'Log out',

        'verified' => 'Your email address has been successfully verified.',
        'already_verified' => 'Your email address has already been verified.',

        'help' => "Check your spam or junk folder if you don't see the email in your inbox.",
    ],

    // Two-Factor Authentication
    'two_factor' => [
        'title' => 'Two-Factor Authentication',

        'authentication_code' => 'Authentication code',
        'authentication_code_description' => 'Enter the 6-digit code from your authenticator app to continue.',

        'recovery_code' => 'Recovery code',
        'recovery_code_description' => 'Enter one of your emergency recovery codes to access your account.',

        'otp_code' => 'OTP code',
        'otp_code_placeholder' => 'Enter your OTP code',

        'recovery_code_placeholder' => 'Enter your recovery code',

        'continue' => 'Continue',
        'verifying' => 'Verifying...',

        'or' => 'or',

        'use_recovery_code' => 'Use recovery code',
        'use_authentication_code' => 'Use authentication code',

        'authentication_hint' => 'Use the code generated by your authenticator app.',
        'recovery_hint' => 'Each recovery code can only be used once.',

        'invalid_code' => 'The provided authentication code is invalid.',
        'invalid_recovery_code' => 'The provided recovery code is invalid.',
        'failed' => 'Two-factor authentication failed. Please try again.',
        'success' => 'Two-factor authentication successful.',
    ],

    // Passkey
    'passkey' => [
        'title' => 'Passkey',
        'heading' => 'Log in with Passkey',
        'description' => 'Use your device Passkey to securely log in.',

        'login' => 'Log in with Passkey',
        'confirm' => 'Confirm with Passkey',

        'authenticating' => 'Verifying Passkey...',
        'success' => 'Successfully logged in using Passkey.',

        'failed' => 'The Passkey could not be verified.',
        'unsupported' => 'Your device or browser does not support Passkey.',
        'cancelled' => 'Passkey authentication was cancelled.',
        'not_found' => 'Passkey not found.',
        'not_allowed' => 'Use of the Passkey was not allowed.',
    ],

    // Password Change
    'password_change' => [
        'title' => 'Change Password',

        'current_password' => 'Current password',
        'new_password' => 'New password',
        'confirm_password' => 'Confirm new password',

        'button' => 'Change password',
        'changing' => 'Changing password...',

        'success' => 'Password changed successfully.',
        'failed' => 'Password could not be changed.',
        'current_password_incorrect' => 'The current password is incorrect.',
    ],

    // Email Change
    'email_change' => [
        'title' => 'Change Email Address',

        'current_email' => 'Current email',
        'new_email' => 'New email',
        'password' => 'Password',

        'button' => 'Change email',
        'changing' => 'Changing email...',

        'success' => 'Email address changed successfully.',
        'failed' => 'Email address could not be changed.',
        'verification_required' => 'Please verify your new email address.',
    ],

    // Account Recovery
    'recovery' => [
        'title' => 'Account Recovery',
        'description' => 'Use an available recovery method to regain access to your account.',

        'code' => 'Recovery code',
        'code_placeholder' => 'Enter your recovery code',

        'verify' => 'Verify',
        'verifying' => 'Verifying...',

        'invalid' => 'The recovery code is invalid.',
        'success' => 'Account recovery was successful.',
    ],

];