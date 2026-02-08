function showTab(tabName, btn) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    const tab = document.getElementById(tabName);
    if (tab) tab.classList.add('active');
    if (btn && btn.classList) btn.classList.add('active');
}

function changeRole(userId, currentRole) {
    const newRole = currentRole === 'admin' ? 'usuario' : 'admin';
    if (confirm(`¿Cambiar rol a "${newRole}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="change_role">
            <input type="hidden" name="id" value="${userId}">
            <input type="hidden" name="role" value="${newRole}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function editUsuario(userId, nombre) {
    const newNombre = prompt('Editar nombre:', nombre);
    if (newNombre !== null && newNombre.trim() !== '') {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="update_usuario">
            <input type="hidden" name="id" value="${userId}">
            <input type="hidden" name="nombre" value="${newNombre}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function editReceta(recetaId, nombre) {
    const newNombre = prompt('Editar nombre de receta:', nombre);
    if (newNombre !== null && newNombre.trim() !== '') {
        alert('Para editar ingredientes e instrucciones, usa el botón de edición en la página de recetas.');
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="update_receta">
            <input type="hidden" name="id" value="${recetaId}">
            <input type="hidden" name="nombre" value="${newNombre}">
            <input type="hidden" name="ingredientes" value="">
            <input type="hidden" name="instrucciones" value="">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function editSuscripcion(nombre, correo, privacidad) {
    const newNombre = prompt('Editar nombre:', nombre);
    if (newNombre !== null && newNombre.trim() !== '') {
        const aceptarPrivacidad = confirm('¿Acepta la política de privacidad?');
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="update_suscripcion">
            <input type="hidden" name="correo" value="${correo}">
            <input type="hidden" name="nombre" value="${newNombre}">
            ${aceptarPrivacidad ? '<input type="hidden" name="privacidad" value="1">' : ''}
        `;
        document.body.appendChild(form);
        form.submit();
    }
}