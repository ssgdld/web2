<?php
class Evento {
    public string $id;
    public string $descripcion;
    public string $tipo;
    public string $lugar;
    public string $fecha;
    public string $hora;

    public function __construct(
        string $id,
        string $descripcion,
        string $tipo,
        string $lugar,
        string $fecha,
        string $hora
    ) {
        $this->id          = $id;
        $this->descripcion = $descripcion;
        $this->tipo        = $tipo;
        $this->lugar       = $lugar;
        $this->fecha       = $fecha;
        $this->hora        = $hora;
    }

    public function resumen(): string {
        return "{$this->fecha} {$this->hora} — {$this->descripcion} en {$this->lugar}";
    }

    public static function filtrarPorTipo(array $eventos, string $tipoBuscado): array {
        return array_values(array_filter(
            $eventos,
            fn($e) => strcasecmp($e->tipo, $tipoBuscado) === 0
        ));
    }

    public static function buscarPorClave(array $eventos, string $clave): array {
        return array_values(array_filter(
            $eventos,
            fn($e) =>
                stripos($e->descripcion, $clave) !== false ||
                stripos($e->lugar, $clave) !== false
        ));
    }
}