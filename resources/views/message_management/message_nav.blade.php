@foreach($messages as $message)
<div class="dropdown-list">
<div class="image-wrapper">
  <img class="profile-img" src="{{ asset('picture/'.$message->avatar) }}" alt="profile image">
</div>
<div class="content-wrapper">
  <small class="name">{{ $message->name }}</small>
  <small class="content-text">{{ $message->message }}</small>
</div>
</div>
@endforeach