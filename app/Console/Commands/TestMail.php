<?php

namespace App\Console\Commands;

use App\Mail\ResidentRegistrationStatusMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    protected $signature = 'mail:test {email : The email address that should receive the test message}';

    protected $description = 'Send a test email using the current Laravel mail configuration.';

    public function handle(): int
    {
        $email = (string) $this->argument('email');
        $smtp = config('mail.mailers.smtp');
        $from = config('mail.from');

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->error('Please provide a valid recipient email address.');

            return self::INVALID;
        }

        $this->line('Current mail configuration:');
        $this->line('MAIL_MAILER=' . config('mail.default'));
        $this->line('MAIL_HOST=' . data_get($smtp, 'host'));
        $this->line('MAIL_PORT=' . data_get($smtp, 'port'));
        $this->line('MAIL_ENCRYPTION=' . (data_get($smtp, 'encryption') ?: 'none'));
        $this->line('MAIL_USERNAME=' . (filled(data_get($smtp, 'username')) ? '<set>' : '<empty>'));
        $this->line('MAIL_PASSWORD=' . (filled(data_get($smtp, 'password')) ? '<set>' : '<empty>'));
        $this->line('MAIL_FROM_ADDRESS=' . data_get($from, 'address'));
        $this->line('MAIL_EHLO_DOMAIN=' . (data_get($smtp, 'local_domain') ?: '<empty>'));

        $resident = new User([
            'name' => 'SMTP Test Recipient',
            'email' => $email,
        ]);
        $resident->user_id = 'smtp-test';

        try {
            Mail::to($email)->send(new ResidentRegistrationStatusMail(
                resident: $resident,
                status: 'approved',
                loginUrl: url('/login'),
            ));
        } catch (\Throwable $exception) {
            $this->error('Mail send failed: ' . $exception->getMessage());
            $this->line('Check storage/logs/laravel.log for the full exception trace.');

            return self::FAILURE;
        }

        $this->info('Test email sent to ' . $email . '.');

        return self::SUCCESS;
    }
}
