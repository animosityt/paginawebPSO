<?php
$pageTitle    = 'Usuarios y perfiles de la comunidad · Cancha Grande';
$pageDesc     = 'Perfiles de la comunidad de Cancha Grande: creá el tuyo con un nombre y una clave de 6 números, subí tu foto y mirá a los demás miembros.';
$paginaActiva = 'usuarios';
$usaSupabase  = true;
$paginaJs     = ['usuarios'];
require __DIR__ . '/includes/head.php';
?>
<?php require __DIR__ . '/includes/nav.php'; ?>

<main id="contenido" class="wrap">


  <header>
    <span class="eyebrow">Perfiles de la comunidad</span>
    <h1>Usuarios</h1>
    <p class="subtitle">
      Creá un perfil con tu nombre, una clave de 6 números y, si querés, una foto. Después vas a aparecer
      en la lista de <b>Miembros</b>.
    </p>
  </header>

  <div class="notice">
    <h2>Cómo funciona la clave</h2>
    <p>
      Es un PIN de 6 números para que solo vos puedas editar tu perfil. Lo guardamos cifrado, pero como es
      corto, no lo uses para otras cuentas ni para nada importante. Si te lo olvidás, no podemos recuperarlo:
      escribinos por <a href="contacto.php">contacto</a> y te lo restablecemos.
    </p>
  </div>

  <section aria-labelledby="h-equipo">
    <h2 class="section-title" id="h-equipo">Equipo</h2>
    <p class="section-lead">Quienes se ocupan de cargar los partidos y cerrar cada temporada.</p>

    <!-- editar: agregá o sacá tarjetas copiando el bloque de abajo -->
    <div class="users-grid">
      <article class="user-card">
        <div class="user-avatar">AN</div>
        <div class="user-meta">
          <span class="user-name">Animosity</span>
          <span class="user-role">Fundador · Desarrollo</span>
          <span class="badge badge-admin">Admin</span>
        </div>
      </article>

      <article class="user-card">
        <div class="user-avatar">AI</div>
        <div class="user-meta">
          <span class="user-name">Aitor</span>
          <span class="user-role">Fundador · Datos</span>
          <span class="badge badge-admin">Admin</span>
        </div>
      </article>
    </div>
  </section>

  <section aria-labelledby="h-tu-perfil">
    <h2 class="section-title" id="h-tu-perfil">Tu perfil</h2>
    <p class="section-lead">Creá un perfil o entrá al tuyo para hacer cambios.</p>

    <div class="contact-card profile-card">

      <!-- ---------- todavía no inició sesión ---------- -->
      <div id="perfilAnonimo">
        <div class="filter-chips" id="profileTabs" style="margin-bottom:22px;">
          <button class="chip active" data-tab="crear">Crear perfil</button>
          <button class="chip" data-tab="entrar">Ya tengo cuenta</button>
        </div>

        <form class="form-grid" id="formCrear">
          <label>
            Nombre de usuario
            <input type="text" id="crearNombre" required minlength="2" maxlength="24" placeholder="Cómo te vamos a ver">
          </label>
          <label>
            Clave de 6 números
            <input type="password" id="crearPin" required pattern="[0-9]{6}" maxlength="6" inputmode="numeric" placeholder="••••••" autocomplete="new-password">
          </label>
          <label>
            Repetí la clave
            <input type="password" id="crearPinConfirma" required pattern="[0-9]{6}" maxlength="6" inputmode="numeric" placeholder="••••••" autocomplete="new-password">
          </label>
          <label>
            Puesto favorito <span style="opacity:.6; text-transform:none; letter-spacing:0;">(opcional)</span>
            <select id="crearPuesto">
              <option value="">Sin definir</option>
              <option>Arquero</option>
              <option>Defensor</option>
              <option>Mediocampista</option>
              <option>Delantero</option>
            </select>
          </label>
          <button type="submit" class="btn btn-primary" style="justify-content:center" id="crearBtn">Crear perfil</button>
          <p class="form-note">Nombre único para todo el sitio — si ya está tomado, te lo avisamos.</p>
        </form>

        <form class="form-grid" id="formEntrar" hidden>
          <label>
            Nombre de usuario
            <input type="text" id="entrarNombre" required placeholder="Tu nombre de usuario">
          </label>
          <label>
            Clave de 6 números
            <input type="password" id="entrarPin" required pattern="[0-9]{6}" maxlength="6" inputmode="numeric" placeholder="••••••" autocomplete="current-password">
          </label>
          <button type="submit" class="btn btn-primary" style="justify-content:center" id="entrarBtn">Entrar</button>
        </form>

        <p class="form-feedback" id="perfilFeedbackAnonimo" hidden></p>
      </div>

      <!-- ---------- ya inició sesión ---------- -->
      <div id="perfilLogueado" hidden>
        <div class="profile-edit-head">
          <div class="user-avatar profile-avatar-grande" id="miAvatarPreview">
            <span class="user-initials" id="miAvatarIniciales"></span>
          </div>
          <div>
            <h3 class="profile-greeting">
              Hola, <span id="miNombre"></span>
            </h3>
            <button type="button" class="btn btn-ghost" id="cerrarSesionPerfilBtn" style="padding:8px 16px; font-size:14px;">Cerrar sesión</button>
          </div>
        </div>

        <form class="form-grid" id="formEditar" style="margin-top:22px;">
          <label>
            Foto de perfil <span style="opacity:.6; text-transform:none; letter-spacing:0;">(opcional, cuadrada, hasta 3MB)</span>
            <input type="file" id="editarFoto" accept="image/png,image/jpeg,image/webp">
          </label>
          <label>
            Puesto favorito
            <select id="editarPuesto">
              <option value="">Sin definir</option>
              <option>Arquero</option>
              <option>Defensor</option>
              <option>Mediocampista</option>
              <option>Delantero</option>
            </select>
          </label>
          <label>
            Confirmá tu clave para guardar
            <input type="password" id="editarPin" required pattern="[0-9]{6}" maxlength="6" inputmode="numeric" placeholder="••••••" autocomplete="current-password">
          </label>
          <button type="submit" class="btn btn-primary" style="justify-content:center" id="editarBtn">Guardar cambios</button>
        </form>

        <p class="form-feedback" id="perfilFeedbackLogueado" hidden></p>
      </div>

    </div>
  </section>

  <section aria-labelledby="h-miembros">
    <h2 class="section-title" id="h-miembros">Miembros</h2>
    <p class="section-lead">Jugadores de la comunidad con perfil propio.</p>

    <div class="users-grid" id="miembrosGrid">
      <div class="cards-empty"><span class="spinner"></span> Cargando miembros…</div>
    </div>
  </section>

  <section aria-labelledby="h-como-va-a-funcionar">
    <h2 class="section-title" id="h-como-va-a-funcionar">Cómo va a funcionar</h2>
    <p class="section-lead">Lo que ya está y lo que falta.</p>

    <div class="steps">
      <div class="step">
        <div>
          <h3>Perfil con clave propia</h3>
          <p><b>Ya está.</b> Podés crear un perfil con una clave de 6 números, sin necesidad de usar un mail.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Foto y puesto personalizados</h3>
          <p><b>Ya está.</b> Subí una foto y elegí tu puesto favorito para que aparezcan en tu tarjeta de miembro.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Vincular el perfil del juego</h3>
          <p>Vincular tu perfil con tu nombre de Pro Soccer Online para que tus partidos y tu cuenta queden conectados.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Permisos por rol</h3>
          <p>Darles a los admins la opción de habilitar a otros miembros para cargar partidos, sin tener que tocar el código.</p>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
