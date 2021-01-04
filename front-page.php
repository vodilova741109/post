<?php get_header();?> 
<main class="front-page-header">
	<div class="container">
		<div class="hero">	
			<div class="left">
				<?php
				//  объявляемем глобальную переменную
				global $post;

				$myposts = get_posts([ 
					'numberposts' => 1,
					'category_name'  => 'web-design, javascript, css, html',
					'orderby'     => 'date',
					
				]);
				// проверяем есть ли посты
				if( $myposts ){
					// если есть запускаем цикл
					foreach( $myposts as $post ){
						setup_postdata( $post );
						?>
					<!-- Вывода постов, функции цикла: the_title() и т.д. -->
					<img src="<?php the_post_thumbnail_url()?>" alt="" class="post-thumb">
					<?php $author_id = get_the_author_meta('ID'); ?>
					<a href="<?php echo get_author_posts_url($author_id ) ?>" class="author">
					<img src="<?php echo get_avatar_url($author_id)?>" alt="" class="avatar">
						<div class="author-bio">
							<span class="author-name"><?php the_author()?></span>
							<span class="author-rank"><?php
              // получаем список всех ролей
              $roles = wp_roles()->roles;
              // узнаем текущую роль пользователя
              $current_role = get_the_author_meta('roles', $author_id)[0];
              // в цикле перебираем все роли
              foreach ($roles  as $role => $value) {
                // если наша текущая роль совпадает с ролью из списка, то выводим 
                if($role == $current_role ){
                  echo ($value['name']);
                }
              }
              ?>
					</span>
						</div>
					</a>
						<div class="post-text"> 
						<!-- <?php the_category()?> заменили функцией ниже -->
							<?php
							

							foreach (get_the_category() as $category) {
							
								printf(
									'<a href="%s" class="category-link %s">%s</a>',									
									esc_url( get_category_link($category) ),
									esc_html($category -> slug),
									esc_html($category -> name)								
									
								);
							}
							?>
					
							<h2 class="post-title"><?php the_title()?></h2>
							<a href="<?php echo get_the_permalink()?>" class="more">Читать далее</a>						
						</div>
					<!-- /.post-text -->
				<?php 
						}
					} else {
						// Постов не найдено
						?> <p> Постов нет </p> <?php
					}

					wp_reset_postdata(); // Сбрасываем $post
					?>
			</div>
			<!-- /.left -->
			<div class="right"> 
				<h3 class="recommend">Рекомендуем</h3>
				<ul class="posts-list">
				<?php
					//  объявляемем глобальную переменную
					global $post;

						$myposts = get_posts([ 
							'numberposts' => 5,
							'offset' => 1,
							'category_name'  => 'javascript, css, html, web-design',
							
							
						]);
						// проверяем есть ли посты
						if( $myposts ){
							// если есть запускаем цикл
							foreach( $myposts as $post ){
								setup_postdata( $post );
								?>
							<!-- Вывода постов, функции цикла: the_title() и т.д. -->
						<li class="post">
							<?php
								
						 
								foreach (get_the_category() as $category) {
									printf(
										'<a href="%s" class="category-link %s">%s</a>',									
										esc_url( get_category_link($category) ),
										esc_html($category -> slug),
										esc_html($category -> name)									
										
									);
								}
								?>
							<a class="post-permalink" href="<?php echo get_the_permalink()?>" class="more"><h4 class="post-title"><?php echo  mb_strimwidth (get_the_title(), 0, 60, '...' )?></h4></a>
							
						</li>
						<?php 
							}
						} else {
							// Постов не найдено
							?> <p> Постов нет </p> <?php
						}

						wp_reset_postdata(); // Сбрасываем $post
						?>
						</ul>
					</div>
			<!-- /.right -->
			</div>				
		</div>
	<!-- /hero -->
	</div>
	<!-- /container -->
</main> 
<!-- /main -->	
<div class="container">
	<ul class="article-list">
		<?php
				//  объявляемем глобальную переменную
				global $post;

					$myposts = get_posts([ 
						'numberposts' =>4,
						'category_name' => 'news',
						'order'=> 'ASC',
						
						
						
					]);
					// проверяем есть ли посты
					if( $myposts ){
						// если есть запускаем цикл
						foreach( $myposts as $post ){
							setup_postdata( $post );
							?>
						<!-- Вывода постов, функции цикла: the_title() и т.д. -->
					<li class="article-item">
					
						<a class="article-permalink" href="<?php echo get_the_permalink()?>" class="more">
						<h4 class="article-title"><?php echo  mb_strimwidth (get_the_title(), 0, 50, '...' )?></h4>
						</a>
						<img width="65" height="65" src="<?php echo get_the_post_thumbnail_url(null, 'thumbnail')?>" alt="">
						
					</li>
					<?php 
						}
					} else {
						// Постов не найдено
						?> <p> Постов нет </p> <?php
					}

					wp_reset_postdata(); // Сбрасываем $post
					?>
	</ul>
	<!-- /article-list -->
		
	<div class="main-grid">
		<ul class="article-grid">
			<?php		
				global $post;
				// формируем запрос в БД
				$query = new WP_Query( [
					'posts_per_page' => 7,
					'category__not_in' =>	42,	
				] );
				// проверяем, есть ли посты
				if ( $query->have_posts() ) {
					// создаем переменную-счетчик постов
					$cnt = 0;
					// пока есть посты, выводим их
					while ( $query->have_posts() ) {
						$query->the_post();
						// увеличиваем счетчик постов
						$cnt++;
						
						switch ($cnt) {
							// выводи первый пост
								case '1':
									?>
									<li class="article-grid-item article-grid-item-1">
										<a href="<?php the_permalink()?>" class="article-grid-permalink">
										
											<img class="article-grid-thumb" src="
											<?php 
												//должно находится внутри цикла
												if( has_post_thumbnail() ) {
													echo get_the_post_thumbnail_url();
												}
												else {
													echo get_template_directory_uri().'/assets/images/img-default.png';
												}
												?>">
											<span class="category-name">
												<?php $category = get_the_category(); 
												echo $category[0]->name; ?>
											</span>		
												<h4 class="article-grid-title"><?php echo get_the_title()?></h4>
													<div class="article-grid-excerpt"><?php echo  mb_strimwidth (get_the_excerpt() , 0, 90, '...' ) ?></div>	
												
													<div class="article-grid-info">
														<div class="author">
															<?php $author_id = get_the_author_meta('ID'); ?>										
															<img src="<?php echo get_avatar_url($author_id)?>" alt="" class="author-avatar">
															<span class="author-name"><strong><?php the_author() ?> </strong>: <?php the_author_meta( 'description' ) ?></span>	
															<div class="comments">
															<svg class="comments-icon" width="19" height="15" fill="#BCBFC2" class="icon photo-report-icon">
															<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
															</svg>
															
																<span class="comments-counter">
																<?php comments_number( '0', '1', '%')?>
																</span>
															</div>							
														</div>
													</div>							
																	
											</span>
										</a>
									</li>
									<!-- /.article-grid-item -->
									<?php 
								break;
							// выводи второй пост
								case '2':
									?>
									<li class="article-grid-item article-grid-item-2">
									<img src="<?php echo get_the_post_thumbnail_url( ) ?>" alt="" class="article-grid-thumb">									
										<a href="<?php the_permalink()?>" class="article-grid-permalink">
										<span class="tag">
											<?php $posttags = get_the_tags();
											if ($posttags) {
												echo $posttags[0]->name . '';
											}
											?>
										</span>
										<span class="category-name">
											<?php $category = get_the_category(); 
														if ($category) {
															echo $category[0]->name . '';
														}
										 ?>
											<h4 class="article-grid-title"><?php the_title()?></h4>									
													<div class="article-grid-info">
														<div class="author">
															<?php $author_id = get_the_author_meta('ID'); ?>							
															<img src="<?php echo get_avatar_url($author_id)?>" alt="" class="author-avatar">
															<div class="author-info">
																<span class="author-name"><strong><?php the_author() ?> </strong></span>	
																<span class="date"><?php the_time('j F') ?></span>
																<div class="comments">
																<svg class="comments-icon" width="19" height="15" fill="#fff" class="icon photo-report-icon">
																<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
																</svg>
																	<span class="comments-counter">
																	<?php comments_number( '0', '1', '%')?></span>		
																	</div>															
																<div class="likes">
																<svg class="comments-icon" width="19" height="15" fill="#fff" class="icon photo-report-icon">
																<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#heart"></use>
																</svg>
																	<span class="comments-counter"><?php comments_number( '0', '1', '%')?></span>	
																</div>
															</div>	
													
															
																					

														</div>
													</div>	
																
										
										</a>
									</li>
									<!-- /.article-grid-item -->
								
										<?php 	
								break;
							// выводи  третийпост	
								case '3':
									?>
										<li class="article-grid-item article-grid-item-3">
											<a href="<?php the_permalink() ?>" class="article-grid-permalink">
												<img src="<?php echo get_the_post_thumbnail_url() ?>" alt="" class="article-thumb">
												<h4 class="article-grid-title" ><?php echo the_title() ?></h4>
											</a>							

										</li>
									<?php

								break;	

							// выводим остальные посты
							default:
									?>
										<li class="article-grid-item article-grid-item-default">
											<a href="<?php the_permalink() ?>" class="article-grid-permalink">									
												<h4 class="article-grid-title" ><?php echo mb_strimwidth(get_the_title(), 0, 40, '...') ?></h4>
												<div class="article-grid-excerpt">
													<?php echo mb_strimwidth(get_the_excerpt(), 0, 86, '...')?>
													<br>
													<span class="article-grid-date"><?php the_time('j F') ?></span>
												</div>	
											</a>							

										</li>
									<?php
								break;
						}
						?>
						<!-- Вывода постов, функции цикла: the_title() и т.д. -->
						<?php 
					}
				} else {
					// Постов не найдено
				}

				wp_reset_postdata(); // Сбрасываем $post
				?>
		</ul> 	
			<!-- подключаем сайтбар -->
			<?php get_sidebar(); ?>		
			<!-- подключаем сайтбар 2 -->
			<?php get_sidebar('meta'); ?>
		
	</div>
</div>
<!-- /container -->
<?php		
global $post;

$query = new WP_Query( [
	'posts_per_page' => 1,
	'category_name'        => 'investigation',
] );

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		?>
		<section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.45), rgba(64, 48, 61, 0.85)), url(<?php echo get_the_post_thumbnail_url() ?>) no-repeat center center">
			<div class="container">
				<h2 class="investigation-title"><?php the_title()?></h2>
				<a href="<?php echo get_the_permalink()?>" class="more">Читать далее</a>	
			</div>

		</section>
		<?php 
	}
} else {
	// Постов не найдено
}

wp_reset_postdata(); // Сбрасываем $post
?>

<div class="container">
<div class="main-grid">
	<ul class="article-block">
		<?php
			global $post;

			$myposts = get_posts([ 
				'numberposts' => 6,
				'cat' => 25,
				'category__not_in' =>	42,	
				
			]);

			if( $myposts ){
				foreach( $myposts as $post ){
					setup_postdata( $post );
					?>  
				
							<li class="article-block-item article-block-item-1">
								<a href="<?php the_permalink()?>" class="article-block-permalink">
								<img class="article-block-thumb"src="<?php echo get_the_post_thumbnail_url()?>" alt="" >
					      <div class="article-block-text">
									<div class="article-block-text-header">
										<span class="category-name">
											<?php $category = get_the_category(); 
											echo $category[0]->name; ?>							
										
										</span>		
										<svg class="comments-icon" width="19" height="15" fill="#BCBFC2" class="icon photo-report-icon">
										<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#bookmark"></use>
										</svg>
														

									</div>
									
										<h4 class="article-block-title"><?php echo get_the_title()?></h4>
												<div class="article-block-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 200, '...')?></div>	
										
											<div class="article-block-info">
												<div class="metrics">	
												
													<span class="article-grid-date"><?php the_time('j F') ?></span>												
													<div class="comments">
													<svg class="comments-icon" width="19" height="15" fill="#BCBFC2" class="icon photo-report-icon">
													<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
													</svg>
															
														<span class="comments-counter">
															<?php comments_number( '0', '1', '%')?>
														</span>
													</div>	
													<div class="likes">
														<svg class="comments-icon" width="19" height="15" fill="#BCBFC2" class="icon photo-report-icon">
														<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#heart"></use>
														</svg>
														
														<span class="comments-counter"><?php comments_number( '0', '1', '%')?>
														</span>	
														</div>						
												</div>
											</div>							
															
								</div>
									
								</a>
							</li>
				
						

					<?php 
				}
			} else {
				// Постов не найдено
			}

			wp_reset_postdata(); // Сбрасываем $post
		?>		
	</ul>	
	<div class="article-posts">
				<!-- подключаем сайтбар home -->
				<?php get_sidebar('home'); ?>		

	</div>
	<!-- /.article-posts-->

				
</div>
</div>
<div class="special">
	<div class="container">
		<div class="special-grid">
			<?php		
				global $post;

				$query = new WP_Query( [
					'posts_per_page' => 1,
					'category_name'        => 'foto-report',
				] );

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						

						?>
							<div class="photo-report">
								<!-- Slider main container -->
								<div class="swiper-container photo-report-slider">
										<!-- Additional required wrapper -->
										<div class="swiper-wrapper">
												<!-- Slides -->
												<?php $images = get_attached_media( 'image' );
													foreach ($images as $image){
														echo '<div class="swiper-slide"><img src="';									
														print_r($image -> guid);
														echo '"></div>';
													}
												?>
											
										</div>
										<!-- If we need pagination -->
										<div class="swiper-pagination"></div>

									
								</div>
							<div class="photo-report-content">							
								<?php
											foreach (get_the_category() as $category) {
												printf(
													'<a href="%s" class="category-link">%s</a>',									
													esc_url( get_category_link($category) ),											
													esc_html($category -> name)									
													
												);												}
										?>									
											<?php $author_id = get_the_author_meta('ID'); ?>
											<a href="<?php echo get_author_posts_url($author_id ) ?>" class="author">
											<img src="<?php echo get_avatar_url($author_id)?>" alt="" class="avatar">
												<div class="author-bio">
													<span class="author-name"><?php the_author()?></span>
													<span class="author-rank">
														<?php
															// получаем список всех ролей
															$roles = wp_roles()->roles;
															// узнаем текущую роль пользователя
															$current_role = get_the_author_meta('roles', $author_id)[0];
															// в цикле перебираем все роли
															foreach ($roles  as $role => $value) {
																// если наша текущая роль совпадает с ролью из списка, то выводим 
																if($role == $current_role ){
																	echo ($value['name']);
																}
															}
														?>
													</span>
												</div>
											</a>
							
											<h3 class="photo-report-title"><?php the_title() ?></h3>
											<a href="<?php echo get_the_permalink()?>" class="button photo-report-button">
												<svg width="19" height="15" class="icon photo-report-button-icon">
													<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#images"></use>
												</svg>
												Смотреть Фото 
												<span class="photo-report-counter"><?php count($images)?></span>
											</a>
							</div>											
								
						</div>						
						<?php 
					}
				} else {
					// Постов не найдено
				}

				wp_reset_postdata(); // Сбрасываем $post
			?>
		
			<div class="other">
				<div class="career-block">
					<div class="career-block-content">
						<div class="career-block-content-text"> 
							<?php
								//  объявляемем глобальную переменную
							global $post;

							$myposts = get_posts([ 
								'numberposts' => 1,							
								'category_name'  => 'career',
								
								]);
								// проверяем есть ли посты
								if( $myposts ){
									// если есть запускаем цикл
									foreach( $myposts as $post ){
										setup_postdata( $post );
										?>
									<!-- Вывода постов, функции цикла: the_title() и т.д. -->					
								
										<!-- <?php the_category()?> заменили функцией ниже -->
											<?php
											foreach (get_the_category() as $category) {
												printf(
													'<a href="%s" class="category-link %s">%s</a>',									
													esc_url( get_category_link($category) ),
													esc_html($category -> slug),
													esc_html($category -> name)									
													
												);
											}
											?>
									
											<h2 class="post-title"><?php the_title()?></h2>
											<div class="article-grid-excerpt"><?php echo  mb_strimwidth (get_the_excerpt() , 0, 90, '...' ) ?></div>	
											<a href="<?php echo get_the_permalink()?>" class="more">Читать далее</a>						
								
									<?php 
									}
										} else {
											// Постов не найдено
											?> <p> Постов нет </p> <?php
										}

										wp_reset_postdata(); // Сбрасываем $post
								?>
								</div>
								<!-- /.post-text -->
						 
							
					</div>
					<div class="career-block-img"> 	<img  src="<?php echo get_template_directory_uri(); ?>/assets/images/career.png" alt="">	</div>
				
					</div>
				
				<!-- /career  -->
				<div class="useful-block">
				<?php
						global $post;

						$myposts = get_posts([ 
							'numberposts' => 2,							
							'category__in'    => 42,
							'category_name' => '"useful',
						]);

						if( $myposts ){
							foreach( $myposts as $post ){
								setup_postdata( $post );
								?>
								<div class="useful-block-content">
								<a href="<?php the_permalink() ?>" class="useful-block-permalink">									
										<h4 class="article-grid-title" ><?php echo mb_strimwidth(get_the_title(), 0, 40, '...') ?></h4>
										<div class="article-grid-excerpt">
											<?php echo mb_strimwidth(get_the_excerpt(), 0, 76, '...')?>
											<br>
											<span class="article-grid-date"><?php the_time('j F') ?></span>
										</div>	
									</a>	


								</div>
								<?php 
							}
						} else {
							// Постов не найдено
						}

						wp_reset_postdata(); // Сбрасываем $post
						?>
				
				
					</div> 	

			</div>
			
		</div>
	</div>
</div>



				
					




<?
get_footer();