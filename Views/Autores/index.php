<?php include 'layouts/header.php'; ?>
<div class="container mt-5">
    <h1>Gestión de Autores</h1>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Agregar Autor</button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="autoresTable">
            <?php foreach ($autores as $autor): ?>
                <tr id="autor-<?php echo $autor['id']; ?>">
                    <td><?php echo $autor['id']; ?></td>
                    <td><?php echo $autor['nombre']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick='openEditModal(<?php echo json_encode($autor); ?>)'>Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteAutor(<?php echo $autor['id']; ?>)">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para Crear Autor -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Agregar Autor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Autor -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Autor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Crear Autor
    document.getElementById('createForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const nombre = document.getElementById('nombre').value;
    const formData = new FormData();
    formData.append('nombre', nombre);
    axios.post('<?php echo BASE_URL; ?>autores/store', formData, {
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    })
    .then(response => {
        console.log('Respuesta completa:', response);
        if (response.data.success) {
            const autor = response.data.autor;
            const tbody = document.getElementById('autoresTable');
            tbody.innerHTML += `
                <tr id="autor-${autor.id}">
                    <td>${autor.id}</td>
                    <td>${autor.nombre}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick='openEditModal(${JSON.stringify(autor)})'>Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteAutor(${autor.id})">Eliminar</button>
                    </td>
                </tr>
            `;
            bootstrap.Modal.getInstance(document.getElementById('createModal')).hide();
            document.getElementById('createForm').reset();
        } else {
            alert(response.data.message || 'Error desconocido');
        }
    })
    .catch(error => {
        console.error('Error en la petición:', error);
        alert('Error en la solicitud: ' + error.message);
    });
});

    // Abrir modal de edición
    function openEditModal(autor) {
        document.getElementById('edit_id').value = autor.id;
        document.getElementById('edit_nombre').value = autor.nombre;
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    // Actualizar Autor
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('edit_id').value;
        const nombre = document.getElementById('edit_nombre').value;
        const formData = new FormData();
        formData.append('nombre', nombre);
        axios.post('<?php echo BASE_URL; ?>autores/update/' + id, formData)
            .then(response => {
                if (response.data.success) {
                    const autor = response.data.autor;
                    const row = document.getElementById(`autor-${autor.id}`);
                    row.cells[1].textContent = autor.nombre;
                    bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                } else {
                    alert(response.data.message || 'Error desconocido');
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                alert('Error en la solicitud: ' + error.message);
            });
    });

    // Eliminar Autor
    function deleteAutor(id) {
        if (confirm('¿Estás seguro de eliminar este autor?')) {
            axios.get('<?php echo BASE_URL; ?>autores/delete/' + id)
                .then(response => {
                    if (response.data.success) {
                        document.getElementById(`autor-${id}`).remove();
                    } else {
                        alert(response.data.message || 'Error desconocido');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>
<?php include 'layouts/footer.php'; ?>