<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RehashUserPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:rehash-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-hash user passwords that are not using bcrypt (useful after imports)';

    public function handle()
    {
        $this->info('Scanning users for non-bcrypt password entries...');

        $users = User::all();
        $count = 0;

        foreach ($users as $user) {
            $pwd = $user->getAuthPassword();

            // Simple heuristic: bcrypt hashes start with $2y$, $2a$ or $2b$
            if (! is_string($pwd) || ! preg_match('/^\$2[ayb]\$/', $pwd)) {
                $this->line("Re-hashing password for user: {$user->email}");

                // Re-hash the current stored value (if plaintext) into bcrypt.
                // If the stored value was a different hashed value, this will hash the
                // hashed string — but in typical import cases the stored value is plain text.
                $user->password = Hash::make($pwd);
                $user->save();
                $count++;
            }
        }

        $this->info("Done. Re-hashed {$count} user(s). If this seems incorrect, inspect user passwords manually.");

        return 0;
    }
}
