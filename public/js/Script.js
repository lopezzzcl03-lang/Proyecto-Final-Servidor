// Cambia el rol del usuario y envia un formulario POST al backend.
function changeRole(userId, currentRole) {
    // Operador ternario: elige el rol opuesto al actual.
    const newRole = currentRole === 'admin' ? 'usuario' : 'admin';
    // confirm() muestra un cuadro de confirmacion y devuelve true/false.
    if (confirm(`¿Cambiar rol a "${newRole}"?`)) {
        // Lee el token CSRF expuesto en window (si existe).
        const token = window.CSRF_TOKEN || '';
        // Crea un formulario en memoria para enviar datos por POST.
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

// Rellena el modal de edicion de usuario.
function prepareEditUser(userId, nombre) {
    document.getElementById('userId').value = userId;
    document.getElementById('editUserNombre').value = nombre;
}

// Rellena el modal de edicion de receta con valores existentes.
function prepareEditReceta(recetaId, nombre, ingredientes, instrucciones) {
    document.getElementById('recetaId').value = recetaId;
    document.getElementById('editRecetaNombre').value = nombre;
    document.getElementById('editRecetaIngredientes').value = ingredientes;
    document.getElementById('editRecetaInstrucciones').value = instrucciones;
}

// Decodifica texto en Base64 a UTF-8 para recuperar caracteres especiales.
function decodeBase64Utf8(value) {
    try {
        // atob() devuelve bytes en latin1; se convierten a Uint8Array para TextDecoder.
        const bytes = Uint8Array.from(atob(value || ''), c => c.charCodeAt(0));
        return new TextDecoder().decode(bytes);
    } catch (e) {
        // Si la cadena no es valida, devuelve vacio para evitar romper la UI.
        return '';
    }
}

// Lee data-* del boton y prepara el formulario de edicion de receta.
function prepareEditRecetaFromButton(button) {
    if (!button || !button.dataset) return;
    prepareEditReceta(
        button.dataset.recetaId || '',
        decodeBase64Utf8(button.dataset.recetaNombre),
        decodeBase64Utf8(button.dataset.recetaIngredientes),
        decodeBase64Utf8(button.dataset.recetaInstrucciones)
    );
}

// Rellena el modal de edicion de suscripcion.
function prepareEditSuscripcion(nombre, correo, privacidad) {
    document.getElementById('suscripcionCorreo').value = correo;
    document.getElementById('editSuscripcionNombre').value = nombre;
    // "checked" recibe booleano: true si privacidad vale 1.
    document.getElementById('editSuscripcionPrivacidad').checked = privacidad === 1;
}
