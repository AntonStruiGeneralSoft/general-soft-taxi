<?php

namespace App\Services\API;

use App\Models\User;
use App\Models\Car;
use App\Classes\RoleEnum;
use Log;
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
                    'email' => $data['email'],
                    'password' => $data['password']
                ]);

                $car = Car::create($data['car']);

                $user->car()->save($car);

                return 'Driver has been successfully created';

            } else {
                return 'The driver does not have the necessary fields';
            }
        }

        User::create($data);

        RegisterService::sendActivationEmail($data['email'], $data['firstName'], $data['lastName']);

        return 'User has been successfully created';
    }

    static private function sendActivationEmail($email, $firstName, $lastName) {
        Mail::send('mail', ['firstName' => $firstName, 'lastName' => $lastName, 'link' => ''], function ($message) use($email, $firstName, $lastName){
            $message->to($email, $firstName . ' ' . $lastName);
            $message->subject('Регистрация');
        });
    }
}