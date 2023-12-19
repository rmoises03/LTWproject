document.addEventListener('DOMContentLoaded', (event) => {
    const editButtons = document.querySelectorAll('.edit-ticket-button');
//vai tratar de registar a confirmação do click do botão edit
    editButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const ticketId = button.dataset.ticketId;
            window.location.href = `../pages/edit_ticket.php?id=${ticketId}`;
        });
    });
});
