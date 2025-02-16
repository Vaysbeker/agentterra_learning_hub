<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class InstallerController extends Controller
{
    public function index()
    {
        return view('installer.step1', ['requirements' => $this->checkRequirements()]);
    }

    private function checkRequirements()
    {
        return [
            'PHP Version (>=8.1)' => version_compare(PHP_VERSION, '8.1.0', '>='),
            'BCMath' => extension_loaded('bcmath'),
            'Ctype' => extension_loaded('ctype'),
            'Fileinfo' => extension_loaded('fileinfo'),
            'JSON' => extension_loaded('json'),
            'Mbstring' => extension_loaded('mbstring'),
            'OpenSSL' => extension_loaded('openssl'),
            'PDO' => extension_loaded('pdo'),
            'Tokenizer' => extension_loaded('tokenizer'),
            'XML' => extension_loaded('xml'),
        ];
    }

    public function step2()
    {
        return view('installer.step2');
    }

    public function install(Request $request)
    {
        // 1. Создаём .env, если его нет
        if (!File::exists(base_path('.env'))) {
            File::copy(base_path('.env.example'), base_path('.env'));
        }

        // 2. Записываем данные базы в .env
        $this->setEnvironmentValue('DB_HOST', $request->db_host);
        $this->setEnvironmentValue('DB_DATABASE', $request->db_name);
        $this->setEnvironmentValue('DB_USERNAME', $request->db_user);
        $this->setEnvironmentValue('DB_PASSWORD', $request->db_pass);

        // 3. Генерируем APP_KEY
        Artisan::call('key:generate');

        // 4. Запускаем миграции
        Artisan::call('migrate:fresh --seed');

        // 5. Создаём роли и права
        $this->createRolesAndPermissions();

        // 6. Создаём пользователя
        $this->createAdminUser($request);

        return view('installer.step3');
    }

    private function setEnvironmentValue($key, $value)
    {
        $path = base_path('.env');
        $content = File::get($path);
        $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
        File::put($path, $content);
    }

    private function createRolesAndPermissions()
    {
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);

        $permissions = [
            'manage users', 'view dashboard', 'edit settings'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdminRole->syncPermissions($permissions);
    }

    private function createAdminUser($request)
    {
        $admin = User::firstOrCreate(
            ['email' => $request->admin_email],
            [
                'name' => $request->admin_name,
                'password' => Hash::make($request->admin_password),
            ]
        );

        $admin->assignRole('Super Admin');
    }
}
