<?php

namespace App\Services\API;

use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Car;
use App\Classes\RoleEnum;
use Mail;

class RegisterService
{
    static public function registerUser($data) {
        if ($data['role'] === RoleEnum::DRIVER) {
            if (isset($data['car'], $data['car']['make'], $data['car']['model'], $data['car']['year'], $data['car']['color'])) {

                $user = User::create([
                    'firstName' => $data['firstName'],
                    'lastName' => $data['lastName'],
                    'role' => RoleEnum::DRIVER,
                    'activationLink' => Str::uuid(),
                    'email' => $data['email'],
                    'password' => $data['password']
                ]);

                $car = Car::create($data['car']);

                $user->car()->save($car);

                self::sendActivationEmail($user);

                return true;

            } else {
                return false;
            }
        }

        $data['activationLink'] = Str::uuid();
        $user = User::create($data);

        self::sendActivationEmail($user);

        return true;
    }

    static private function sendActivationEmail($user) {
        Mail::send('mail', [
                'firstName' => $user->firstName,
                'lastName' => $user->lastName,
                'link' => env('APP_URL', 'http://localhost') . '/activation/' . $user -> activationLink
            ],
            function ($message) use($user) {
                $message->to($user->email, $user->firstName . ' ' . $user->lastName);
                $message->subject('Регистрация');
            }
        );
    }
}