<script>
    const apiUrl = "{{ url('api/users') }}";
    let users = [];
    let currentPage = 1;
    let totalPages = 1;
    let isLoading = false;
    let searchQuery = '';

    async function fetchUsers(page = 1, searchQuery = '') {
        if (isLoading || currentPage > totalPages) return;

        isLoading = true;

        try {
            const response = await fetch(`${apiUrl}?page=${page}&search=${searchQuery}`);
            const data = await response.json();
            totalPages = data.pagination.total_pages;

            const newUsers = data.data.filter(user => !users.some(existingUser => existingUser.id === user.id));
            users = [...users, ...newUsers];

            renderUsers();
            currentPage++;
        } catch (error) {
            console.error("Error fetching users:", error);
        } finally {
            isLoading = false;
        }
    }

    function renderUsers() {
        const userList = document.getElementById('user-list');
        userList.innerHTML = '';

        const fragment = document.createDocumentFragment();
        users.forEach(user => {
            const row = document.createElement('tr');
            row.setAttribute('data-id', user.id);
            row.setAttribute('id', `row-${user.id}`);

            row.innerHTML = `
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${user.phone || 'N/A'}</td>
                <td>${user.role_name || 'N/A'}</td>
                <td>
                    <img src="${user.profile_image || '/default-avatar.png'}" alt="Profile" class="img-thumbnail" width="50">
                </td>
                <td>
                    <div class="d-flex align-items-center justify-content-center gap-1">
                        <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm" onclick="editUser(${user.id})">Edit</a>
                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm" onclick="deleteUser(${user.id})">Delete</a>
                    </div>
                </td>
            `;
            fragment.appendChild(row);
        });
        userList.appendChild(fragment);
    }

    let typingTimeout;
    document.getElementById('search-bar').addEventListener('input', function() {
        clearTimeout(typingTimeout);
        searchQuery = this.value;
        typingTimeout = setTimeout(function() {
            if (searchQuery) {
                users = [];
                currentPage = 1;
                fetchUsers(currentPage, searchQuery);
            } else {
                fetchUsers();
            }
        }, 500);
    });



    async function showCreateUserModal() {
        resetUserForm();
        document.getElementById('userModalLabel').innerText = 'Create User';
        document.querySelector('button[type="submit"]').innerText = 'Create User';
        $('#userModal').modal('show');
    }

    document.getElementById('create-user-button').addEventListener('click', showCreateUserModal);

    async function editUser(id) {
        const response = await fetch(`${apiUrl}/${id}`);
        const user = await response.json();
        if (!user || !user.data) {
            toasterAlert('error', 'Unable to edit user: data is missing.');
            return;
        }

        document.getElementById('user-id').value = user.data.id;
        document.getElementById('user-name').value = user.data.name;
        document.getElementById('user-email').value = user.data.email;
        document.getElementById('user-phone').value = user.data.phone || '';
        document.getElementById('user-description').value = user.data.description || '';
        document.getElementById('user-role_id').value = user.data.role_id || '';

        const profileImageInput = document.getElementById('user-profile_image');
        const profileImagePreview = document.getElementById('profile-image-preview');
        if (profileImageInput && user.data.profile_image) {
            profileImagePreview.src = user.data.profile_image;
            profileImagePreview.style.display = 'block';
        } else {
            profileImagePreview.style.display = 'none';
        }

        document.getElementById('userModalLabel').innerText = 'Edit User';
        document.querySelector('button[type="submit"]').innerText = 'Update User';
        $(document).find('#userModal').modal('show');
    }

    document.getElementById('user-form').addEventListener('submit', async (event) => {
        event.preventDefault();
        $('.validation-error-block').remove();

        const id = document.getElementById('user-id').value;
        const name = document.getElementById('user-name').value;
        const email = document.getElementById('user-email').value;
        const phone = document.getElementById('user-phone').value;
        const description = document.getElementById('user-description').value;
        const role = document.getElementById('user-role_id').value;
        const profile_image = document.getElementById('user-profile_image').files[0];

        const formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('description', description);
        formData.append('role_id', role);
        if (profile_image) formData.append('profile_image', profile_image);

        const method = 'POST';
        const url = id ? `/api/users/${id}` : '/api/users';

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'Accept':'application/json',
                },
                body: formData
            });
            if (response.ok) {
                const result = await response.json();
                toasterAlert('success', id ? 'User updated successfully' : 'User created successfully');
                if (!id) {
                    users.unshift(result.data);
                    renderUsers();
                } else {
                    users = [];
                    currentPage = 1;
                    fetchUsers(currentPage, searchQuery);
                }
                $(document).find('#userModal').modal('hide');
                resetUserForm();
            } else {
                const errorResponse = await response.json();
                const errors = errorResponse.errors;
                $.each(errors, function(key, item) {
                    const errorLabel = `<span class="validation-error-block text-danger">${item[0]}</span>`;
                    const inputElement = $("#user-" + key);
                    if (inputElement.length) {
                        inputElement.after(errorLabel);
                    }
                });
            }
        } catch (error) {
            toasterAlert('error', 'An error occurred while saving the user.');
        }
    });

    function resetUserForm() {
        document.getElementById('user-form').reset();
        document.getElementById('profile-image-preview').style.display = 'none';
        document.getElementById('user-id').value = '';
    }

    async function deleteUser(id) {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "Once clicked, the record will be deleted!",
            icon: "warning",
            showDenyButton: true,
            confirmButtonText: "Yes, delete it!",
            denyButtonText: "No, keep it",
            allowOutsideClick: false,
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(`${apiUrl}/${id}`, { method: 'DELETE' });

                if (response.ok) {
                    users = users.filter(user => user.id !== id);
                    $(document).find('#row-' + id).remove();
                    renderUsers();
                    toasterAlert('success', 'User deleted successfully');
                } else {
                    const error = await response.json();
                    toasterAlert('error', error.message);
                }
            } catch (error) {
                toasterAlert('error', 'An error occurred while deleting the user.');
            }
        }
    }

    $(function() {
        let scrollTimeout;
        $('div.common-table').scroll(function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
                    fetchUsers(currentPage, searchQuery);
                }
            }, 200);   
        })

        fetchUsers();
    });
</script>
