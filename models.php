<?php
class Project {
  public $id;
  public $name;
  public $goalAmount;
  public $raised;

  public function __construct($id, $name, $goalAmount, $raised = 0) {
    $this->id = $id;
    $this->name = $name;
    $this->goalAmount = $goalAmount;
    $this->raised = $raised;
  }

  public function progressPercent() {
    return min(100, ($this->raised / $this->goalAmount) * 100);
  }

  public function addDonation($amount) {
    if ($amount > 0) {
      $this->raised += $amount;
      return true;
    }
    return false;
  }
}

class Event {
  public $id;
  public $title;
  public $date;
  public $description;

  public function __construct($id, $title, $date, $description) {
    $this->id = $id;
    $this->title = $title;
    $this->date = new DateTime($date);
    $this->description = $description;
  }

  public function isUpcoming() {
    return $this->date > new DateTime();
  }

  public function formattedDate() {
    return $this->date->format('Y-m-d');
  }
}

class Donation {
  public $donorName;
  public $amount;
  public $projectId;
  public $date;

  public function __construct($donorName, $amount, $projectId) {
    $this->donorName = $donorName;
    $this->amount = $amount;
    $this->projectId = $projectId;
    $this->date = new DateTime();
  }

  public function summary() {
    return "{$this->donorName} donó \${$this->amount} USD el " . $this->date->format('d/m/Y');
  }
}

class Evento {
  private int $id;
  private string $titulo, $descripcion, $tipo, $lugar;
  private DateTime $fecha, $hora;

  public function __construct(int $id, string $titulo, string $descripcion,
                              string $tipo, string $lugar, string $fecha, string $hora) {
    $this->id = $id;
    $this->titulo = $titulo;
    $this->descripcion = $descripcion;
    $this->tipo = $tipo;
    $this->lugar = $lugar;
    $this->fecha = new DateTime($fecha);
    $this->hora = DateTime::createFromFormat('H:i', $hora);
  }

  public function getId(): int             { return $this->id; }
  public function getTitulo(): string      { return $this->titulo; }
  public function getDescripcion(): string { return $this->descripcion; }
  public function getTipo(): string        { return $this->tipo; }
  public function getLugar(): string       { return $this->lugar; }
  public function getFecha(): DateTime     { return $this->fecha; }
  public function getHora(): DateTime      { return $this->hora; }

  public function formattedFecha(): string { return $this->fecha->format('Y-m-d'); }
  public function formattedHora(): string  { return $this->hora->format('H:i'); }
}

class EventManager {
  private array $eventos = [];

  public function addEvento(Evento $e): void {
    $this->eventos[$e->getId()] = $e;
  }

  public function listar(): array {
    return array_values($this->eventos);
  }

  public function buscar(string $term): array {
    $t = mb_strtolower($term);
    return array_filter($this->eventos, fn(Evento $e) =>
      str_contains(mb_strtolower($e->getTitulo()), $t) ||
      str_contains(mb_strtolower($e->getDescripcion()), $t)
    );
  }

  public function filtrarPorTipo(string $tipo): array {
    return array_filter($this->eventos, fn(Evento $e) => $e->getTipo() === $tipo);
  }

  public function filtrarPorFecha(string $desde, string $hasta): array {
    $d1 = new DateTime($desde);
    $d2 = new DateTime($hasta);
    return array_filter($this->eventos, fn(Evento $e) =>
      $e->getFecha() >= $d1 && $e->getFecha() <= $d2
    );
  }
}
?>