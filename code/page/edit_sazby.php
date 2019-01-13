<?php if ($authService->hasIdentity()) : ?>
    <?php
    include './page/editace.php';
    ?>
    <main>
        <h2>Sazby</h2>
    </main>
<?php else : ?>
    <section id="hero">
        <h2>Pro editaci tabulek musíte být přihlášeni.</h2>
    </section>
<?php endif; ?>