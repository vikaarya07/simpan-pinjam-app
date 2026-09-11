<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General Messages
    |--------------------------------------------------------------------------
    */

    'success' => 'Success.',
    'error' => 'An error occurred.',
    'warning' => 'Warning.',
    'info' => 'Information.',

    /*
    |--------------------------------------------------------------------------
    | CRUD Messages
    |--------------------------------------------------------------------------
    */

    'created' => ':attribute has been created successfully.',
    'updated' => ':attribute has been updated successfully.',
    'deleted' => ':attribute has been deleted successfully.',
    'restored' => ':attribute has been restored successfully.',

    'create_failed' => 'Failed to create :attribute.',
    'update_failed' => 'Failed to update :attribute.',
    'delete_failed' => 'Failed to delete :attribute.',

    'not_found' => ':attribute not found.',
    'already_exists' => ':attribute already exists.',
    'cannot_delete' => ':attribute cannot be deleted.',
    'cannot_update' => ':attribute cannot be updated.',

    /*
    |--------------------------------------------------------------------------
    | Confirmation Messages
    |--------------------------------------------------------------------------
    */

    'confirm' => [
        'title' => 'Are you sure?',
        'delete' => 'Deleted data cannot be recovered.',
        'delete_title' => 'Delete data?',
        'delete_text' => 'This data will be permanently deleted.',
        'cancel' => 'Cancel',
        'confirm' => 'Yes, continue',
        'delete_confirm' => 'Yes, delete',
    ],

    /*
    |--------------------------------------------------------------------------
    | Form Messages
    |--------------------------------------------------------------------------
    */

    'form' => [
        'saved' => 'Data has been saved successfully.',
        'save_failed' => 'Failed to save data.',
        'reset' => 'The form has been reset.',
        'invalid' => 'Please check the entered data.',
        'no_changes' => 'No changes were saved.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Search & Filter Messages
    |--------------------------------------------------------------------------
    */

    'search' => [
        'no_results' => 'No data found.',
        'no_data' => 'No data available yet.',
        'empty' => 'No data matched your search.',
    ],

    'filter' => [
        'applied' => 'Filter applied successfully.',
        'reset' => 'Filter has been reset.',
        'no_results' => 'No data matches the selected filter.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Member / Customer Messages
    |--------------------------------------------------------------------------
    */

    'member' => [
        'created' => 'Member has been added successfully.',
        'updated' => 'Member data has been updated successfully.',
        'deleted' => 'Member has been deleted successfully.',
        'not_found' => 'Member not found.',
        'has_loans' => 'Member cannot be deleted because they still have loans.',
        'has_active_loan' => 'Member still has an active loan.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Loan Messages
    |--------------------------------------------------------------------------
    */

    'loan' => [
        'created' => 'Loan has been created successfully.',
        'updated' => 'Loan has been updated successfully.',
        'deleted' => 'Loan has been deleted successfully.',
        'not_found' => 'Loan not found.',

        'insufficient_saving' => 'The saving balance is insufficient to create this loan.',
        'invalid_principal' => 'The loan principal is invalid.',
        'principal_must_greater' => 'The new loan principal must be greater than the previous remaining balance.',
        'previous_loan_not_found' => 'Previous loan not found.',
        'previous_loan_not_running' => 'The previous loan is not currently running.',
        'maximum_installment' => 'The loan has reached the maximum number of installments.',
        'cannot_delete_paid' => 'A loan with payments cannot be deleted.',
        'cannot_update_paid' => 'A loan with payments cannot be updated.',

        'overdue_created' => 'Overdue loan has been created successfully.',
        'overdue_not_available' => 'An overdue loan cannot be created yet.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Messages
    |--------------------------------------------------------------------------
    */

    'payment' => [
        'created' => 'Payment has been recorded successfully.',
        'updated' => 'Payment has been updated successfully.',
        'deleted' => 'Payment has been deleted successfully.',
        'not_found' => 'Payment not found.',

        'saved' => 'Payment has been saved successfully.',
        'skipped' => 'Payment has been marked as skipped.',
        'cleared' => 'Payment has been confirmed successfully.',

        'invalid_amount' => 'The payment amount is invalid.',
        'amount_must_positive' => 'The payment amount must be greater than 0.',
        'maximum_installment' => 'The maximum number of installments has been reached.',
        'already_paid' => 'This installment has already been paid.',
        'cannot_pay' => 'The payment cannot be processed.',
        'loan_not_found' => 'Loan not found.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Saving Messages
    |--------------------------------------------------------------------------
    */

    'saving' => [
        'created' => 'Saving transaction has been created successfully.',
        'updated' => 'Saving transaction has been updated successfully.',
        'deleted' => 'Saving transaction has been deleted successfully.',
        'not_found' => 'Saving transaction not found.',

        'insufficient_balance' => 'The saving balance is insufficient.',
        'invalid_amount' => 'The saving amount is invalid.',
        'balance_updated' => 'Saving balance has been updated successfully.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Meeting Messages
    |--------------------------------------------------------------------------
    */

    'meeting' => [
        'created' => 'Meeting has been created successfully.',
        'updated' => 'Meeting has been updated successfully.',
        'deleted' => 'Meeting has been deleted successfully.',
        'not_found' => 'Meeting not found.',

        'already_exists' => 'A meeting on that date already exists.',
        'has_payments' => 'The meeting cannot be deleted because it already has payments.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Report Messages
    |--------------------------------------------------------------------------
    */

    'report' => [
        'generated' => 'Report has been generated successfully.',
        'downloaded' => 'Report has been downloaded successfully.',
        'sent' => 'Report has been sent successfully.',
        'failed' => 'Failed to generate the report.',
        'not_found' => 'Report not found.',
        'no_data' => 'There is no data available for this report.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Messages
    |--------------------------------------------------------------------------
    */

    'notification' => [
        'sent' => 'Notification has been sent successfully.',
        'failed' => 'Failed to send notification.',
        'created' => 'Notification has been created successfully.',
        'deleted' => 'Notification has been deleted successfully.',
        'not_found' => 'Notification not found.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Messages
    |--------------------------------------------------------------------------
    */

    'auth' => [
        'login_success' => 'You have logged in successfully.',
        'login_failed' => 'The email or password is incorrect.',
        'logout_success' => 'You have logged out successfully.',
        'register_success' => 'Registration was successful.',
        'password_changed' => 'Password has been changed successfully.',
        'password_reset' => 'Password has been reset successfully.',
        'email_updated' => 'Email address has been updated successfully.',
        'verification_sent' => 'A verification link has been sent to your email address.',
        'verification_success' => 'Your email has been verified successfully.',
    ],

    /*
    |--------------------------------------------------------------------------
    | File Messages
    |--------------------------------------------------------------------------
    */

    'file' => [
        'uploaded' => 'File has been uploaded successfully.',
        'upload_failed' => 'Failed to upload file.',
        'downloaded' => 'File has been downloaded successfully.',
        'not_found' => 'File not found.',
        'invalid' => 'The file is invalid.',
    ],

    /*
    |--------------------------------------------------------------------------
    | PDF Messages
    |--------------------------------------------------------------------------
    */

    'pdf' => [
        'generated' => 'PDF has been generated successfully.',
        'downloaded' => 'PDF has been downloaded successfully.',
        'failed' => 'Failed to generate PDF.',
    ],

];