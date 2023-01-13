<?php

// Clase inmutable que maneja la información esencial del usuario
// No lleva la clave o pin, ya que solo son necesarias al autenticar
// Tampoco la cedula, puesto que solo aparece en el resumen de usuarios
class Usuario
{
    private int $id;
    private string $nombre;
    private int $perfil;
    private int $subsistema;

    public function id(): int
    {
        return $this->id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function perfil(): int
    {
        return $this->perfil;
    }

    public function subsistema(): int
    {
        return $this->subsistema;
    }

    public function __construct(
        int $id,
        string $nombre,
        int $perfil,
        int $subsistema,
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->perfil = $perfil;
        $this->subsistema = $subsistema;
    }

    public function esta_permitido(int $perfil_minimo, int $subsistema_esperado): bool
    {
        $perfil_ok =  $this->perfil <= $perfil_minimo;

        $subsistema_ok = $this->subsistema === $subsistema_esperado ||
            $this->subsistema === SUBSISTEMA_TODOS ||
            $subsistema_esperado === SUBSISTEMA_TODOS;

        return $perfil_ok && $subsistema_ok;
    }
}
