<?php
declare(strict_types=1);

class Goku {
    public string $nome;
    public int $poder;
    public int $estagio;
    public string $bio;

    const KEY = 'goku_obj';

    public static function estagios(): array {
        return [
            0 => ['nome' => 'Base', 'boost' => 0, 'gif' => 'https://i.pinimg.com/originals/13/ec/da/13ecda317fa8f216b9e4c1075d7f514d.gif', 'desc' => 'Forma base do Goku.'],
            1 => ['nome' => 'SSJ', 'boost' => 2000, 'gif' => 'https://imagens.net.br/wp-content/uploads/2024/07/envie-amor-em-movimento-gifs-especiais-para-namorada-2.gif', 'desc' => 'Super Saiyajin.'],
            2 => ['nome' => 'SSJ2', 'boost' => 3000, 'gif' => 'https://media.tenor.com/QwBjOuwOWG4AAAAM/dragon-ball-z-goku.gif', 'desc' => 'Super Saiyajin 2.'],
            3 => ['nome' => 'SSJ3', 'boost' => 5000, 'gif' => 'https://i.imgur.com/pGNHjz4.gif', 'desc' => 'Super Saiyajin 3.'],
            4 => ['nome' => 'SSJ4', 'boost' => 8000, 'gif' => 'https://i.redd.it/59ei9e6qv9ve1.gif', 'desc' => 'Super Saiyajin 4.'],
            5 => ['nome' => 'SSJ God', 'boost' => 12000, 'gif' => 'https://pa1.aminoapps.com/6473/5c505e297f764c31377111afa14d048ab12b5b93_hq.gif', 'desc' => 'Super Saiyajin God.'],
            6 => ['nome' => 'SSJ Blue', 'boost' => 15000, 'gif' => 'https://i.pinimg.com/originals/1b/eb/a7/1beba794e3edf0d43428c49ccd74300e.gif', 'desc' => 'Super Saiyajin Blue.'],
            7 => ['nome' => 'SSB Kaioken', 'boost' => 18000, 'gif' => 'https://pa1.aminoapps.com/7582/86410593a1757c66a6f1c52e5cb0f3f3e3f9dcd0r1-600-338_hq.gif', 'desc' => 'Blue + Kaioken.'],
            8 => ['nome' => 'Instinto Incompleto', 'boost' => 22000, 'gif' => 'https://i.pinimg.com/originals/a2/03/9d/a2039dd28707f38aca1de985339d58ab.gif', 'desc' => 'Ultra Instinto (Incompleto).'],
            9 => ['nome' => 'Instinto Superior', 'boost' => 26000, 'gif' => 'https://i.pinimg.com/originals/83/a1/bb/83a1bb1bc6719991e62614adc600ef37.gif', 'desc' => 'Ultra Instinto.'],
            10 => ['nome' => 'SSJ100', 'boost' => 30000, 'gif' => 'https://media.tenor.com/DIurmXYNtYEAAAAM/super-saiyan-infinity-super-saiyan100.gif', 'desc' => 'Super Saiyajin 100 (fanmade).']
        ];
    }

    public static function criarBase(): self {
        $g = new self();
        $g->nome = 'Goku';
        $g->estagio = 0;
        $g->poder = 9000;
        $g->bio = 'Saiyajin criado na Terra, defensor do Universo 7.';
        return $g;
    }

    public function forma(): array {
        return self::estagios()[$this->estagio] ?? self::estagios()[0];
    }

    public function podeEvoluir(): bool {
        return $this->estagio < max(array_keys(self::estagios()));
    }

    public function evoluir(): void {
        if ($this->podeEvoluir()) {
            $this->estagio++;
            $boost = (int)(self::estagios()[$this->estagio]['boost'] ?? 0);
            $this->poder += $boost;
        }
    }

    public static function salvar(self $g): void {
        $_SESSION[self::KEY] = [
            'nome' => $g->nome, 'poder' => $g->poder,
            'estagio' => $g->estagio, 'bio' => $g->bio
        ];
    }
    public static function carregar(): ?self {
        if (!isset($_SESSION[self::KEY]) || !is_array($_SESSION[self::KEY])) return null;
        $d = $_SESSION[self::KEY];
        $g = new self();
        $g->nome = (string)($d['nome'] ?? 'Goku');
        $g->poder = (int)($d['poder'] ?? 9000);
        $g->estagio = (int)($d['estagio'] ?? 0);
        $g->bio = (string)($d['bio'] ?? '');
        return $g;
    }
    public static function destruir(): void {
        unset($_SESSION[self::KEY]);
    }
}
