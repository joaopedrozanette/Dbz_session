<?php
declare(strict_types=1);

class GokuController {
    private $bg = 'https://images2.alphacoders.com/100/thumb-1920-1003880.png';

    private function header($title = 'Goku Sessão'){
        echo '<!doctype html><html lang="pt"><head><meta charset="utf-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
        echo '<title>'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'</title>';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '<style>
            body{background:url('.$this->bg.') no-repeat center center fixed;background-size:cover;color:#e7eef7}
            .wrap{max-width:900px;margin:40px auto;padding:16px}
            .card{background:rgba(13,19,32,.92);border:1px solid #1d283a;border-radius:14px;color:white}
            img.card-gif{max-width:100%;border-radius:12px}
        </style>';
        echo '</head><body><div class="wrap">';
        echo '<h2>Dragon Ball — Goku (Sessão simples)</h2>';
        echo '<div class="mt-3">';
        echo '<a class="btn btn-success me-2" href="?r=goku/create">Criar sessão</a>';
        echo '<a class="btn btn-warning me-2" href="?r=goku/evolve">Evoluir</a>';
        echo '<a class="btn btn-danger" href="?r=goku/remove">Remover sessão</a>';
        echo '</div>';
    }

    private function footer(){
        echo '</div></body></html>';
    }

    public function index(){
        $this->header();
        $goku = Goku::carregar();
        echo '<div class="mt-4">';
        if ($goku !== null) {
            $f = $goku->forma();
            echo '<div class="card p-3">';
            echo '<div class="row g-3 align-items-center">';
            echo '<div class="col-md-5 text-center">';
            echo '<img class="card-gif" src="'.htmlspecialchars($f['gif'], ENT_QUOTES, 'UTF-8').'" alt="'.htmlspecialchars($f['nome'], ENT_QUOTES, 'UTF-8').'" />';
            echo '</div>';
            echo '<div class="col-md-7">';
            echo '<h4 class="mb-1">'.htmlspecialchars($goku->nome, ENT_QUOTES, 'UTF-8').' — <span class="badge text-bg-primary">'.htmlspecialchars($f['nome'], ENT_QUOTES, 'UTF-8').'</span></h4>';
            echo '<div class="mb-2"><b>Poder:</b> '.(int)$goku->poder.'</div>';
            echo '<p class="mb-2">'.htmlspecialchars($f['desc'], ENT_QUOTES, 'UTF-8').'</p>';
            echo '<small>'.htmlspecialchars($goku->bio, ENT_QUOTES, 'UTF-8').'</small>';
            echo '</div></div></div>';
        }
        echo '</div>';
        $this->footer();
    }

    public function create(){
        $g = Goku::carregar();
        if ($g === null) {
            $g = Goku::criarBase();
            Goku::salvar($g);
        }
        header('Location: ?r=goku/index'); exit;
    }

    public function evolve(){
        $g = Goku::carregar();
        if ($g === null) {
            $this->header();
            echo '<div class="alert alert-danger mt-3">Crie a sessão do Goku antes de tentar evoluir!</div>';
            $this->footer();
            return;
        }
        if ($g->podeEvoluir()) {
            $g->evoluir();
            Goku::salvar($g);
        }
        header('Location: ?r=goku/index'); exit;
    }

    public function remove(){
        Goku::destruir();
        header('Location: ?r=goku/index'); exit;
    }
}
