function changeRole(userId, currentRole) {
    const newRole = currentRole === 'admin' ? 'usuario' : 'admin';
    if (confirm(`¿Cambiar rol a "${newRole}"?`)) {
        const token = window.CSRF_TOKEN || '';
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="change_role">
            <input type="hidden" name="id" value="${userId}">
            <input type="hidden" name="role" value="${newRole}">
            <input type="hidden" name="csrf_token" value="${token}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function prepareEditUser(userId, nombre) {
    document.getElementById('userId').value = userId;
    document.getElementById('editUserNombre').value = nombre;
}

function prepareEditReceta(recetaId, nombre, ingredientes, instrucciones) {
    document.getElementById('recetaId').value = recetaId;
    document.getElementById('editRecetaNombre').value = nombre;
    document.getElementById('editRecetaIngredientes').value = ingredientes;
    document.getElementById('editRecetaInstrucciones').value = instrucciones;
}

function decodeBase64Utf8(value) {
    try {
        const bytes = Uint8Array.from(atob(value || ''), c => c.charCodeAt(0));
        return new TextDecoder().decode(bytes);
    } catch (e) {
        return '';
    }
}

function prepareEditRecetaFromButton(button) {
    if (!button || !button.dataset) return;
    prepareEditReceta(
        button.dataset.recetaId || '',
        decodeBase64Utf8(button.dataset.recetaNombre),
        decodeBase64Utf8(button.dataset.recetaIngredientes),
        decodeBase64Utf8(button.dataset.recetaInstrucciones)
    );
}

function prepareEditSuscripcion(nombre, correo, privacidad) {
    document.getElementById('suscripcionCorreo').value = correo;
    document.getElementById('editSuscripcionNombre').value = nombre;
    document.getElementById('editSuscripcionPrivacidad').checked = privacidad === 1;
}
