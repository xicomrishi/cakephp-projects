<div class="menu">
    	<ul>
        	<li id="dash_tab_1" class="first dash_tab <?php if($this->params['controller']=='dashboard') echo 'active'; ?>" onclick="get_page('dashboard','.tab_detail');"><a href="javascript://">Dashboard</a></li>
            <li id="dash_tab_2" class="second dash_tab <?php if($this->params['controller']=='trainer') echo 'active'; ?>" onclick="get_page('trainers_list','.tab_detail');"><a href="javascript://">Trainers</a></li>
            <li id="dash_tab_3" class="<?php if($this->params['controller']=='course') echo 'active'; ?> second dash_tab" onclick="get_courses_index('0');"><a href="javascript://">Groups</a></li>
			<li id="dash_tab_3" class="dash_tab <?php if($this->params['controller']=='companies') echo 'active'; ?>" onclick="get_page('companies_list','.tab_detail');"><a href="javascript://">Company</a></li>
            <li id="dash_tab_4" class="second dash_tab <?php if($this->params['controller']=='cms') echo 'active'; ?>" onclick="get_page('get_cms_content','.tab_detail');"><a href="javascript://">CMS</a></li>
            <li id="dash_tab_5" class="dash_tab <?php if($this->params['controller']=='questions') echo 'active'; ?>" onclick="get_page('get_cms_questions','.tab_detail');"><a href="javascript://">Questions</a></li>
            <li id="dash_tab_6" class="dash_tab <?php if($this->params['controller']=='benchmark') echo 'active'; ?>" onclick="get_page('get_benchmark_data','.tab_detail');"><a href="javascript://">Benchmark Data</a></li>
        </ul>
    </div>