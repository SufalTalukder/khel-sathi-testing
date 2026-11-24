<?php
$user_id = Auth::guard('admin')->user()->id;

$modules = DB::table('urm_module_manager')->where('is_menu', '=', 1)->where('module_status', '=', 1)->orderBy('menu_order', 'ASC')->get();
//  dd($modules);
foreach ($modules as $module) {
	// dd( $module->id);

	$role_modules = DB::table('urm_role_module_mapping')->join('urm_page_manager', 'urm_role_module_mapping.page_id', '=', 'urm_page_manager.id')->where('urm_role_module_mapping.user_id', $user_id)->where('urm_page_manager.module_id', '=', $module->id)->orderBy('urm_page_manager.page_order', 'ASC')->groupBy('urm_page_manager.id')->get();
	//  dd($role_modules);
	if ($role_modules) {
		//    dd($role_modules);
		$i = 0;
		// $adminData[$user->name][$module->id] = [];
		foreach ($role_modules as $role_module) {
			//  $menu[$user->name][$module->id]['module_name']= $module->module_name;
			$menu[$module->module_name]['id'] = $module->id;
			$menu[$module->module_name]['module_url'] = $module->module_url;
			$menu[$module->module_name]['menu_icon'] = $module->menu_icon;
			$menu[$module->module_name]['dor'] = $role_module->dor;
			$menu[$module->module_name]['pages'][] = DB::table('urm_page_manager')->where('page_status', '=', 1)->where('is_menu', '=', 1)->where('id', $role_module->page_id)->orderBy('page_order', 'ASC')->first();
			$i++;
		}
	}
}

?>
<ul class="navsidebar" id="accordionExample">
	<li class=" menu_item nav-item">
		<a href="{{url('admin/dashboard')}}">
			<i class="icon icon-home"></i><span>Dashboard </span>
		</a>
	</li>

	@if(isset($menu)) @foreach($menu as $key=>$value_arr)
	<li data-bs-toggle="collapse" data-bs-target="#abc{{$value_arr['id']}}" class="collapsed menu_item">
		<a href="javascript:void(0)"><i class="{{$value_arr['menu_icon']}}"></i><span>{{repairHindi($key)}}</span> <span class="fa fa-caret-down"></span></a>
	</li>
	<ul class="sub-menu collapse" id="abc{{$value_arr['id']}}" data-bs-parent="#accordionExample">
		@foreach($value_arr['pages'] as $page) @if(isset($page) && $page != "")
		@if($page->page_url == 'admin/eklavya_krida_co/query_marked' && !in_array(Auth::guard('admin')->user()->admin_role, [1, 2, 3, 5, 9, 17]))
			@continue
		@endif
		<li><a href="{{url($page->page_url)}}"><i class="{{$page->menu_icon}}"></i><span>{{repairHindi($page->page_name)}}</span></a>
		</li>
		@if(in_array(Auth::guard('admin')->user()->admin_role, [1, 2, 3, 5, 9, 17]) && ($page->page_url == 'admin/eklavya_krida_co/6') && !collect($value_arr['pages'])->contains('page_url', 'admin/eklavya_krida_co/query_marked'))
		<li><a href="{{url('admin/eklavya_krida_co/query_marked')}}"><i class="icon icon-eye"></i><span>Query Marked Applications</span></a>
		</li>
		@endif
		@endif @endforeach
	</ul>
	@endforeach @endif
</ul>