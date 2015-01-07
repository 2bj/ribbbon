{{--LINKS--}}
<ul class="nav nav-pills nav-stacked">
  <li><a href="/projects/{{ $project->id }}"><i class="fa fa-tasks"></i> Tasks</a></li>
  <li><a href="/projects/{{ $project->id }}/credentials"><i class="fa fa-key"></i> Credentials</a></li>
  @if( isOwner($project->id) == true )
    <li><a href="/projects/{{ $project->id }}/manage"><i class="fa fa-cog"></i> Manage</a></li>
  @endif
</ul>
{{--LINKS--}}

{{--MEMBERS--}}
@if(count($members) > 0)
  <hr>
  <ul class="inline-list list-style-none members-list">
    <li><a title="{{ User::find($project->user_id)->full_name }}" class="profile-link" href="/profile">
        <img class="circle" src="{{ User::get_gravatar(User::find($project->user_id)->email) }}"></a></li>
    @foreach($members as $member)
      <li><img class="circle" title="{{ $member->full_name }}" src="{{ User::get_gravatar($member->email)  }}"></li>
    @endforeach
  </ul>
  <div class="clearfix"></div>
@endif
{{--MEMBERS--}}

