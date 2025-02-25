<?php include 'layouts/header.php'; ?>
<div class="container mt-5">
    <h1>Gestión de Libros</h1>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Agregar Libro</button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Autor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="librosTable">
            <?php foreach ($libros as $libro): ?>
                <tr id="libro-<?php echo $libro['id']; ?>">
                    <td><?php echo $libro['id']; ?></td>
                    <td><?php echo $libro['titulo']; ?></td>
                    <td><?php echo $libro['descripcion'] ?? ''; ?></td>
                    <td><?php echo $libro['autor_nombre']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick='openEditModal(<?php echo json_encode($libro); ?>)'>Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteLibro(<?php echo $libro['id']; ?>)">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para Crear Libro -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Agregar Libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="autor_id" class="form-label">Autor</label>
                        <select class="form-control" id="autor_id" name="autor_id" required>
                            <option value="">Seleccione un autor</option>
                            <?php foreach ($autores as $autor): ?>
                                <option value="<?php echo $autor['id']; ?>"><?php echo $autor['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Libro -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit_titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="edit_descripcion" name="descripcion"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_autor_id" class="form-label">Autor</label>
                        <select class="form-control" id="edit_autor_id" name="autor_id" required>
                            <option value="">Seleccione un autor</option>
                            <?php foreach ($autores as $autor): ?>
                                <option value="<?php echo $autor['id']; ?>"><?php echo $autor['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
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
    document.getElementById('createForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const titulo = document.getElementById('titulo').value;
        const descripcion = document.getElementById('descripcion').value;
        const autor_id = document.getElementById('autor_id').value;
        const formData = new FormData();
        formData.append('titulo', titulo);
        formData.append('descripcion', descripcion);
        formData.append('autor_id', autor_id);
        axios.post('<?php echo BASE_URL; ?>libros/store', formData)
            .then(response => {
                if (response.data.success) {
                    const libro = response.data.libro;
                    const tbody = document.getElementById('librosTable');
                    tbody.innerHTML += `
                        <tr id="libro-${libro.id}">
                            <td>${libro.id}</td>
                            <td>${libro.titulo}</td>
                            <td>${libro.descripcion || ''}</td>
                            <td>${libro.autor_nombre}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick='openEditModal(${JSON.stringify(libro)})'>Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteLibro(${libro.id})">Eliminar</button>
                            </td>
                        </tr>
                    `;
                    bootstrap.Modal.getInstance(document.getElementById('createModal')).hide();
                    document.getElementById('createForm').reset();
                } else {
                    alert(response.data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    });

    function openEditModal(libro) {
        document.getElementById('edit_id').value = libro.id;
        document.getElementById('edit_titulo').value = libro.titulo;
        document.getElementById('edit_descripcion').value = libro.descripcion || '';
        document.getElementById('edit_autor_id').value = libro.autor_id;
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('edit_id').value;
        const titulo = document.getElementById('edit_titulo').value;
        const descripcion = document.getElementById('edit_descripcion').value;
        const autor_id = document.getElementById('edit_autor_id').value;
        const formData = new FormData();
        formData.append('titulo', titulo);
        formData.append('descripcion', descripcion);
        formData.append('autor_id', autor_id);
        axios.post('<?php echo BASE_URL; ?>libros/update/' + id, formData)
            .then(response => {
                if (response.data.success) {
                    const libro = response.data.libro;
                    const row = document.getElementById(`libro-${libro.id}`);
                    row.cells[1].textContent = libro.titulo;
                    row.cells[2].textContent = libro.descripcion || '';
                    row.cells[3].textContent = libro.autor_nombre;
                    bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                } else {
                    alert(response.data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    });

    function deleteLibro(id) {
        if (confirm('¿Estás seguro de eliminar este libro?')) {
            axios.get('<?php echo BASE_URL; ?>libros/delete/' + id)
                .then(response => {
                    if (response.data.success) {
                        document.getElementById(`libro-${id}`).remove();
                    } else {
                        alert(response.data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>
<?php include 'layouts/footer.php'; ?>