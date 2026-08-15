<footer class="footer">
    <div class="footer__inner">
        <div class="footer__brand">
            <p class="footer__logo">DESIGN DAN</p>
            <p class="footer__tagline"><?= t('footer.tagline') ?></p>
        </div>

        <div class="footer__col">
            <p class="footer__heading"><?= htmlspecialchars(t('footer.menu_heading')) ?></p>
            <?php foreach ($NAV_SERVICES as $service): ?>
                <a href="<?= url('/') ?>#<?= htmlspecialchars($service['slug']) ?>"><?= htmlspecialchars(t($service['label_key'])) ?></a>
            <?php endforeach; ?>
            <a href="<?= url('/answers/') ?>"><?= htmlspecialchars(t('nav.answers')) ?></a>
        </div>

        <div class="footer__col">
            <p class="footer__heading"><?= htmlspecialchars(t('footer.contact_heading')) ?></p>
            <a href="mailto:designdan2020@gmail.com">designdan2020@gmail.com</a>
            <a href="tel:+639455997774">+63-94-5599-7774</a>
            <a href="https://instagram.com/design_dan2020" target="_blank" rel="noopener">@design_dan2020</a>
            <p class="footer__hours"><?= htmlspecialchars(t('contact.hours.value')) ?></p>
        </div>
    </div>

    <div class="footer__bottom">
        <p>&copy; <?= date('Y') ?> DESIGN DAN. <?= htmlspecialchars(t('footer.rights')) ?></p>
        <div class="footer__legal">
            <a href="#"><?= htmlspecialchars(t('footer.privacy')) ?></a>
            <a href="#"><?= htmlspecialchars(t('footer.terms')) ?></a>
            <a href="<?= url('/admin/login.php') ?>"><?= htmlspecialchars(t('footer.staff_login')) ?></a>
        </div>
    </div>
</footer>

<script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
