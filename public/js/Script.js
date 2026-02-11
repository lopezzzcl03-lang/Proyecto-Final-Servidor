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

function prepareEditSuscripcion(nombre, correo, privacidad) {
    document.getElementById('suscripcionCorreo').value = correo;
    document.getElementById('editSuscripcionNombre').value = nombre;
    document.getElementById('editSuscripcionPrivacidad').checked = privacidad === 1;
}