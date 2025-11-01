<?php

class GokuController {
    private $bg = 'https://images2.alphacoders.com/100/thumb-1920-1003880.png';


    private function flash($msg) {
        $_SESSION['flash'] = $msg;
    }

    private function header($title = 'Goku Sessão', $error = '') {
        echo '<!doctype html><html lang="pt"><head><meta charset="utf-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
        echo '<title>'.htmlspecialchars($title).'</title>';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '<style>
            body{background:url('.$this->bg.') no-repeat center center fixed;background-size:cover;color:#e7eef7}
            .wrap{max-width:900px;margin:40px auto;padding:16px}
            .card{background:rgba(13,19,32,.92);border:1px solid #1d283a;border-radius:14px;color:#fff}
            img.card-gif{max-width:100%;border-radius:12px}
            .brand img{max-height:64px}
        </style>';
        echo '</head><body>';
        echo '<div class="wrap">';

        
        echo '<div class="brand mb-3 text-center">';
        echo '<h2>Dragon Ball — Goku (Sessão simples)</h2>';
        echo '</div>';

        echo '<div class="mt-2">';
        echo '<a class="btn btn-success me-2" href="?r=goku/create">Criar sessão</a>';
        echo '<a class="btn btn-warning me-2" href="?r=goku/evolve">Evoluir</a>';
        echo '<a class="btn btn-danger" href="?r=goku/remove">Remover sessão</a>';
        echo '</div>';

        if ($error !== '') {
            echo '<div class="alert alert-danger mt-3">'.htmlspecialchars($error).'</div>';
        }
    }

    private function footer() {
        echo '</div></body></html>';
    }

    public function index() {
        
        $msg = isset($_SESSION['flash']) ? $_SESSION['flash'] : '';
        unset($_SESSION['flash']);

        
        $this->header('Goku Sessão', $msg);

        $goku = Goku::carregar();
        echo '<div class="mt-4">';
        if ($goku) {
            $f = $goku->forma();
            echo '<div class="card p-3">';
            echo '<div class="row g-3 align-items-center">';
            echo '<div class="col-md-5 text-center">';
            echo '<img class="card-gif" src="'.htmlspecialchars($f['gif']).'" alt="'.htmlspecialchars($f['nome']).'" />';
            echo '</div>';
            echo '<div class="col-md-7">';
            echo '<h4>'.htmlspecialchars($goku->nome).' — <span class="badge text-bg-primary">'.htmlspecialchars($f['nome']).'</span></h4>';
            echo '<div><b>Poder:</b> '.(int)$goku->poder.'</div>';
            echo '<p>'.htmlspecialchars($f['desc']).'</p>';
            echo '<small>'.htmlspecialchars($goku->bio).'</small>';
            echo '</div></div></div>';
        }
        echo '</div>';
        $this->footer();
    }

    public function create() {
        $g = Goku::carregar();
        if (!$g) {
            $g = Goku::criarBase();
            Goku::salvar($g);
        }
        header('Location: ?r=goku/index'); exit;
    }

    public function evolve() {
        $g = Goku::carregar();

       
        if (!$g) {
            $this->flash('Crie a sessão do Goku antes de tentar evoluir!');
            header('Location: ?r=goku/index'); exit;
        }

       
        if (!$g->podeEvoluir()) {
            $this->flash('Não há mais transformações. Limite atingido (SSJ 100).');
            header('Location: ?r=goku/index'); exit;
        }

        
        $g->evoluir();
        Goku::salvar($g);
        header('Location: ?r=goku/index'); exit;
    }

    public function remove() {
        Goku::destruir();
        header('Location: ?r=goku/index'); exit;
    }
}
