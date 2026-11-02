<?php if (!isset($pageTitle)) { http_response_code(403); exit; } ?>
<!-- ===== footer, igual en todas las páginas ===== -->
<footer class="site-footer">
  <div class="footer-links" aria-label="Enlaces externos">
    <div class="footer-link-group">
      <span class="footer-label">GitHub</span>
      <a href="https://github.com/animosityt" aria-label="GitHub de Animosity">Github Animosity</a>
      <a href="https://github.com/aitor-byte" aria-label="GitHub de Aitor">Github Aitor</a>
    </div>
    <div class="footer-link-group">
      <span class="footer-label">Instagram</span>
      <a href="https://instagram.com/aniimossity" aria-label="Instagram de Animosity">Instagram Animosity</a>
      <a href="https://instagram.com/aitor.pez" aria-label="Instagram de Aitor">Instagram Aitor</a>
    </div>
    <div class="footer-link-group">
      <span class="footer-label">Discord</span>
      <a href="#" class="discord-link" aria-label="Discord de Animosity, hover para ver el usuario" data-username="animossiity">Discord Animosity</a>
      <a href="#" class="discord-link" aria-label="Discord de Aitor, hover para ver el usuario" data-username="aitor_rex">Discord Aitor</a>
    </div>
  </div>
  <p class="footer-legal">© 2026 Cancha Grande. Todos los derechos reservados.</p>
  <p class="footer-trademark">Cancha Grande™ es una marca de <span>Leverage™</span>.</p>
</footer>

<?php if (!empty($usaSupabase)): ?>
<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script src="js/config.js"></script>
<?php endif; ?>
<script src="js/menu.js"></script>
<?php foreach (($paginaJs ?? []) as $archivoJs): ?>
<script src="js/<?= $archivoJs ?>.js"></script>
<?php endforeach; ?>

</body>
</html>
