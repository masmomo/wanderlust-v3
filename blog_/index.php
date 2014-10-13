<?php
/* -- FUNCTIONS -- */
function count_news($search_param, $search_op, $search_value){
   $conn   = connDB();
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_news_category AS cat_ LEFT JOIN tbl_news AS news_ ON cat_.category_id = news_.news_category
              WHERE $search_param $search_op '$search_value' AND `category_visibility` = 'Yes' 
			  ORDER BY `news_date`
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_news($search_param, $search_op, $search_value, $start_record, $query_per_page){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_news_category AS cat_ LEFT JOIN tbl_news AS news_ ON cat_.category_id = news_.news_category
              WHERE $search_param $search_op '$search_value' AND `category_visibility` = 'Yes'
			  ORDER BY `news_date`
			  LIMIT $start_record, $query_per_page
			 ";
   $query  = mysql_query($sql, $conn);
   $total  = mysql_num_rows($query);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   $row['rows'] = $total;
   
   return $row;
}


function get_category(){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_news_category WHERE `category_visibility` = 'Yes' ORDER BY `category_name`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


/* -- DEFINED VARIABLE -- */

// REQUEST
$category = $_REQUEST['cat_news'];
$page     = $_REQUEST['cat_record'];


// CONTROL 
if(empty($_REQUEST['cat_news']) || $_REQUEST['cat_news'] == 'all' || empty($_REQUEST['cat_record'])){
   
   $category = '';
   $operator = '';
   $src_val  = '1';
   
   $paging_cat = 'all';
   
   $record = count_news($category, $operator, $src_val);
   
   $total_record = $record['rows'];
   
   $qpp  = 3;
   $page = 1;
   
   if($page == 'all'){
      
	  $start_record   = '0';
	  $query_per_page = $record['rows'];
	  
   }else{
	   
      $start_record   = ($page - 1) * $qpp;
	  $query_per_page = $page * $qpp;
   }
   
}else{
   
   $category = 'category_id';
   $operator = ' = ';
   $src_val  = $_REQUEST['cat_news'];
   
   $paging_cat = $_REQUEST['cat_news'];
   
   $qpp      = 3;
   $page     = $_REQUEST['cat_record'];
   
   $start_record   = ($page - 1) * $qpp;
   $query_per_page = $page * ($qpp - 1);
   
   $record = count_news($category, $operator, $src_val);
   
}



/* -- PAGINATION -- */
function view_pagination($post_total_record, $post_qpp, $post_req_cat, $post_req_filter, $post_req_sort, $post_req_page){
	
   // DEFINED VARIABLE
   $paging['total_record'] = $post_total_record;
   $paging['qpp']          = $post_qpp;
   $paging['total_page']   = ceil($post_total_record / $post_qpp);
   
   //$paging['first']        = 
   
   echo '<ul class="pagination pull-right">';
   echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/blog\">&laquo;</a></li>";
   
   for($i=1; $i <= $paging['total_page']; $i++){
      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/blog-view/".$post_req_cat."/".$i."\">".$i."</a></li>";
   }
   echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/blog-view/".$post_req_cat.'/'.$paging['total_page']."\">&raquo;</a></li>";
   echo '</ul>';
   
}



// CALL FUNCTIONS
$count_news    = count_news($category, $operator, $src_val);
$news          = get_news($category, $operator, $src_val, $start_record, $query_per_page);
$news_category = get_category();
?>

    <div class="container main">
      <div class="content">
        
        <div class="row">
  
          <div class="col-xs-10">

            <!--BLOG INDEX 1-->
            <?php 
			if($count_news['rows'] < 1){
			   echo 'No record(s)';
			   
			}else{
			
			  foreach($news as $news){
            ?>
            <div class="post row">
              <div class="col-xs-3">
                <h2><?php echo $news['news_title'];?></h2>
                <p class="timestamp"><?php echo date('j F Y',strtotime($news['news_date']));?></p>
              </div>
              <div class="col-xs-9">
                <img class="m_b_10" src="<?php echo $prefix_img.$news['news_image'].'&h=300&w=705&q=100';?>">
                <p class="m_b_10"><?php echo substr(preg_replace("/\n/","\n<br>",$news['news_content']),0,300);?></p>
                <a class="read-more" href="<?php echo $prefix_url.cleanurl($news['category_name']).'/'.$news['news_alias'];?>">Read More</a>
              </div>
            </div>
            <?php
			  }
			  
            }
            ?>

            <!--BLOG INDEX 2-->
            <?php 
            //for($i=0;$i<1;$i++){
			foreach($news as $news){
            ?>
            <div class="post row hidden">
              <div class="col-xs-12">
                <h2><?php echo $news['news_title'];?></h2>
                <p class="timestamp m_b_15"><?php echo date('j F Y',strtotime($news['news_date']));?></p>
                <img class="m_b_10" src="<?php echo $prefix_img.$news['news_image'].'&h=300&w=705&q=100';?>">
                <p class="m_b_10"><?php echo substr(preg_replace("/\n/","\n<br>",$news['news_content']),0,300);?></p>
                <a class="read-more" href="<?php echo $prefix_url.cleanurl($news['category_name']).'/'.$news['news_alias'];?>">Read More</a>
              </div>
            </div>
            <?php
			
            }
            ?>

            <!--BLOG INDEX 3-->
            <?php 
            for($i=0;$i<1;$i++){
            ?>
            <div class="post row hidden">
              <div class="col-xs-4">
                <img class="img-responsive" src="<?php echo $prefix_url.'admin/static/thimthumb.php?src=../'.$news['news_image'].'&h=300&w=705&q=100';?>">
              </div>
              <div class="col-xs-8">
                <h2><?php echo $news['news_title'];?></h2>
                <p class="timestamp m_b_5"><?php echo date('j F Y',strtotime($news['news_date']));?></p>
                <p class="m_b_10"><?php echo substr(preg_replace("/\n/","\n<br>",$news['news_content']),0,300);?></p>
                <a class="read-more" href="<?php echo $prefix_url.cleanurl($news['category_name']).'/'.$news['news_alias'];?>">Read More</a>
              </div>
            </div>
            <?php
            }
            ?>

            <!--PAGINATION-->
            <!--
            <ul class="pagination pull-right">
              <li><a href="#">&laquo;</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li><a href="#">&raquo;</a></li>
            </ul>
            -->
            <?php
            /* --- PAGINATION --- */
			echo "Total Record: ".$total_record."<br>";
			echo "Query Per Page: ".$query_per_page.'<br>';
			echo "Category: ".$src_val.'<br>';
			echo "Page: ".$page.'<br>';
			
			view_pagination($total_record, $query_per_page, $paging_cat, $page);
			?>

          </div><!--.col-->

          <!--BLOG CATEGORY-->
          <div class="col-xs-2">
            <div class="category p_l_15">
              <p>Categories</p>
              <ul>
                <?php
				foreach($news_category as $news_category){
                   echo '<li><a href="'.$prefix_url.'blog-view/'.$news_category['category_id'].'/all">'.$news_category['category_name'].'</a></li>';
				}
				?>
                <!--
                <li><a href="">All Posts</a></li>
                <li><a href="">News</a></li>
                <li><a href="">Events</a></li>
                <li><a href="">Others</a></li>
                -->
              </ul>
            </div>
          </div>

        </div><!--.row-->


      </div><!--.content-->
    </div><!--.container.main-->