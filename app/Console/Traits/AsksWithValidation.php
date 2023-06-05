<?php

namespace App\Console\Traits;

use Illuminate\Support\Facades\Validator;

trait AsksWithValidation
{
    private function askWithValidation(string $message, array|string $rules = [], string $name = 'value'): mixed
    {
        $answer = $this->ask($message);

        $validator = Validator::make([
            $name => $answer,
        ], [
            $name => $rules,
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return $this->askWithValidation($message, $rules, $name);
        }

        return $answer;
    }
}
