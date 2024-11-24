function confirmarDelete(event) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Tem certeza que deseja deletar sua conta?',
        html: `
            <p style="margin-bottom: 15px;">Esta ação não pode ser desfeita e você perderá:</p>
            <ul style="text-align: left; display: inline-block;">
                <li>Seu histórico de reservas</li>
                <li>Suas preferências salvas</li>
                <li>Acesso à sua conta ArenaRental</li>
            </ul>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, deletar conta',
        cancelButtonText: 'Cancelar',
        customClass: {
            popup: 'swal-wide',
            title: 'swal-title',
            htmlContainer: 'swal-text',
            confirmButton: 'swal-confirm',
            cancelButton: 'swal-cancel'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm').submit();
        }
    });
    
    return false;
}