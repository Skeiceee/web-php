<?php

namespace Framework;

class Validator {

    protected $errors = [];

    public function __construct(
        protected array $data,
        protected array $rules = []
    ){
        $this->validate();
    }

    public function validate(): void {
        foreach ($this->rules as $field => $rule) {
            $rules = explode('|', $rule);
            $value = trim($this->data[$field]);

            foreach ($rules as $rule) {
                [$name, $param] = array_pad(explode(':', $rule), 2, null);
                
                if($error = $this->hasError($name, $param, $field, $value)) {
                    $this->errors[] = $error;
                    break;
                }
            }
        }
    }

    public function hasError(string $name, ?string $param, string $field, mixed $value): ?string {
        return match ($name) {
                    'required' => $this->validateRequired($field, $value),
                    'min' => strlen($value) < $param ? "$field debe tener al menos $param caracteres." : null,
                    'max' => strlen($value) > $param ? "$field no puede exceder los $param caracteres." : null,
                    'url' => filter_var($value, FILTER_VALIDATE_URL) ? null : "$field debe ser una URL válida.",
                    default => null,
                };
    }

    public function validateRequired(string $field, mixed $value): ?string{
        return empty($value) ? "$field es requerido." : null;
    }

    public function passes(): bool {
        return empty($this->errors);
    }

    public function errors(): array {
        return $this->errors;
    }

}