document.addEventListener("DOMContentLoaded", () => {
    const userList = document.getElementById('users-list');

    function loadUsers() {
        fetch('get_users.php')
            .then(response => response.json())
            .then(users => {
                userList.innerHTML = '';
                users.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.address}</td>
                        <td>${user.userid}</td>
                        <td>
                            <button onclick="editUser(${user.id}) " >Edit</button>
                            <button onclick="deleteUser(${user.id})">Delete</button>
                        </td>
                    `;
                    userList.appendChild(row);
                });
            })
            .catch(error => console.error("Error loading users:", error));
    }

    window.editUser = function(id) {
        fetch(`get_users.php?id=${id}`)
            .then(response => response.json())
            .then(user => {
                const name = prompt('Enter new name:', user.name);
                const email = prompt('Enter new email:', user.email);
                const address = prompt('Edit address:', user.address);  // Corrected variable name
                const userid = prompt('Edit userid:', user.userid);      // Corrected variable name
                if (name && email) {
                    fetch('get_users.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 'update_user',
                            user_id: id,
                            name: name,
                            email: email,
                            address: address,  // Corrected field name
                            userid: userid     // Corrected field name
                        })
                    }).then(() => loadUsers());
                }
            });
    };
    

    window.deleteUser = function(id) {
        if (confirm("Are you sure you want to delete this user?")) {
            fetch(`get_users.php?id=${id}`, { 
                method: 'DELETE',  
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadUsers();  
                } else {
                    alert('Failed to delete user: ' + data.message); 
                }
            })
            .catch(error => {
                alert("Error deleting user");
            });
        }
    };

    loadUsers();  
});

document.addEventListener("DOMContentLoaded", () => {
    const contactQueriesList = document.getElementById('contact-queries-list');

    function loadContactQueries() {
        fetch('get_contact_queries.php')
            .then(response => response.json())
            .then(data => {
                contactQueriesList.innerHTML = '';  
                data.forEach(contact => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${contact.id}</td>
                        <td>${contact.name}</td>
                        <td>${contact.email}</td>
                        <td>${contact.phone}</td>
                        <td>${contact.address}</td>
                        <td>${contact.query}</td>
                        <td>
                            <button onclick="editContact(${contact.id})">Edit</button>
                            <button onclick="deleteContact(${contact.id})">Delete</button>
                        </td>
                    `;
                    contactQueriesList.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching contact queries:', error);
            });
    }

    window.editContact = function(contactId) {
        fetch(`get_contact_queries.php?id=${contactId}`)
            .then(response => response.json())
            .then(contact => {
                const name = prompt('Edit name:', contact.name);
                const email = prompt('Edit email:', contact.email);
                const phone = prompt('Edit phone:', contact.phone);
                const address = prompt('Edit address:', contact.address);
                const query = prompt('Edit query:', contact.query);

                if (name && email && phone && address && query) {
                    fetch('get_contact_queries.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 'update_contact_query',
                            contact_id: contactId,
                            name: name,
                            email: email,
                            phone: phone,
                            address: address,
                            query: query
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Contact query updated successfully');
                            loadContactQueries();  
                        } else {
                            alert('Error updating contact query');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating contact query:', error);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching contact query for edit:', error);
            });
    };

    window.deleteContact = function(contactId) {
        if (confirm("Are you sure you want to delete this contact query?")) {
            fetch(`get_contact_queries.php?id=${contactId}`, {
                method: 'DELETE', 
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Contact query deleted successfully');
                    loadContactQueries();  
                } else {
                    alert('Error deleting contact query');
                }
            })
            .catch(error => {
                console.error('Error deleting contact query:', error);
            });
        }
    };

    window.onload = () => {
        loadContactQueries();
    };
});
