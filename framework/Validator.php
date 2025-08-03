<?php

namespace Framework;

class Validator {

    protected $errors = [];

    public function __construct(
        protected array $data,
        protected array $rules = [],
        protected bool $autoRedirect = true
    ){
        $this->validate();

        if ($this->autoRedirect && !$this->passes()) {
            $this->redirectIfFailed();
        }
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
                    'url' => filter_var($value, FILTER_VALIDATE_URL) === false ? "$field debe ser una URL válida." : null,
                    'email' => filter_var($value, FILTER_VALIDATE_EMAIL) === false ? "$field debe ser un correo electrónico válido." : null,
                    default => throw new \InvalidArgumentException("Regla de validación desconocida: $name"),
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

    public function redirectIfFailed(): void {
        session()->setFlash('errors', $this->errors);

        foreach ($this->data as $key => $value) {
            session()->setFlash('old_' . $key, $value);
        }

        back();
    }

    public static function make(array $data, array $rules, bool $autoRedirect = true): self {
        return new self($data, $rules, $autoRedirect);
    }

}