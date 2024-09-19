document.addEventListener('DOMContentLoaded', function() {
    var addButton = document.getElementById('add-button');
    var addButtonDesktop = document.getElementById('add-button-desktop');
    var addForm = document.getElementById('add-form');
    var contactForm = document.getElementById('contact-form');
    var submitButton = contactForm.querySelector('button[type="submit"]');
    
    function toggleForm() {
        if (addForm.style.display === 'none' || addForm.style.display === '') {
            addForm.style.display = 'block';

            // Gombok letiltása
            if (addButton) addButton.disabled = true;
            if (addButtonDesktop) addButtonDesktop.disabled = true;
        } else {
            addForm.style.display = 'none';

            // Gombok engedélyezése
            if (addButton) addButton.disabled = false;
            if (addButtonDesktop) addButtonDesktop.disabled = false;
        }
    }
    
    if (addButton) {
        addButton.addEventListener('click', toggleForm);
    }
    
    if (addButtonDesktop) {
        addButtonDesktop.addEventListener('click', toggleForm);
    }
    
    var closeModalButton = document.getElementById('close-modal');
    if (closeModalButton) {
        closeModalButton.addEventListener('click', toggleForm);
    }
    
    window.addEventListener('click', function(event) {
        if (event.target == addForm) {
            toggleForm();
        }
    });
    
    contactForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        submitButton.disabled = true;
        submitButton.textContent = 'Küldés...';

        var formData = new FormData(contactForm);

        try {
            var response = await fetch('/add', {
                method: 'POST',
                body: formData
            });
            var data = await response.json();

            if (data.success) {
                var contactLista = document.getElementById('contact-lista');
                
                if (!contactLista) {
                    contactLista = document.createElement('ul');
                    contactLista.id = 'contact-lista';
                    contactLista.className = 'list-group';
                    document.querySelector('.container').insertBefore(contactLista, document.querySelector('.container').childNodes[2]);
                    var noContactsMessage = document.querySelector('.container p');
                    if (noContactsMessage) {
                        noContactsMessage.remove();
                    }
                }

                var newItem = document.createElement('li');
                newItem.className = 'list-group-item d-flex align-items-center';
                
                newItem.innerHTML = `
                    <div class="icon-container">
                        <i class="la la-phone"></i>
                    </div>
                    <div class="contact-details">
                        <div class="row">
                            <div class="col-6">
                                <strong>${data.data.first_name}</strong>
                            </div>
                            <div class="col-6">
                                <strong>${data.data.last_name}</strong>
                            </div>
                        </div>
                        <div class="row">
                            ${data.data.phone ? `
                            <div class="col-6">
                                Telefonszám: ${data.data.phone.replace('+421', '0')}
                            </div>
                            ` : ''}
                            ${data.data.email ? `
                            <div class="col-6">
                                E-mail: ${data.data.email}
                            </div>
                            ` : ''}
                        </div>
                    </div>
                `;
                contactLista.insertBefore(newItem, contactLista.firstChild);

                alert('Sikeres hozzáadás!');
                contactForm.reset();
                toggleForm();
            } else {
                alert('Hiba: ' + data.error);
            }
        } catch (error) {
            console.error('Hiba történt:', error);
            alert('Hiba történt a kérés feldolgozása során.');
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Hozzáadás';
        }
    });
});
