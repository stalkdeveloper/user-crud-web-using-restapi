<div class="modal fade show" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userModalLabel">Edit User</h4>
                <button type="button" class="btn-close btnClose" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>                
            <form id="user-form">
                @csrf
                <div class="modal-body">
                        <input type="hidden" id="user-id">
                        <!-- User Name -->
                        <div class="form-group">
                            <label for="user-name">Name</label>
                            <input type="text" id="user-name" class="form-control">
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="user-email">Email</label>
                            <input type="email" id="user-email" class="form-control">
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label for="user-phone">Phone</label>
                            <input type="text" id="user-phone" class="form-control">
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="user-description">Description</label>
                            <textarea id="user-description" class="form-control"></textarea>
                        </div>

                        <!-- Role -->
                        <div class="form-group">
                            <label for="user-role">Role</label>
                            <select id="user-role_id" class="form-control" name="role_id">
                                @foreach($roles as $key => $item)
                                    <option value="{{$key}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Profile Image -->
                        <div class="form-group">
                            <label for="user-profile_image">Profile Image</label>
                            <input type="file" id="user-profile_image" class="form-control">
                            
                            <!-- Image Preview -->
                            <img id="profile-image-preview" src="" alt="Profile Image Preview" style="display: none; width: 100px; height: 100px; object-fit: cover;">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnClose" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnSave">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>
