<?php
/**
 * LearnPress Categories Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_LP_Categories extends Widget_Base {

	public function get_name() {
        return 'Ellen_LP_Categories';
    }

	public function get_title() {
        return __( 'LearnPress Categories', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-post-list';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'features_inner_section',
			[
				'label' => __( 'Categories Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

            $this->add_control(
                'style',
                [
                    'label' => esc_html__( 'Section Style', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'      => esc_html__( 'Style One', 'ellen-toolkit' ),
                        '2'       => esc_html__( 'Style Two', 'ellen-toolkit' ),
                    ],
                    'default' => '1',
                ]
            );

			$repeater = new Repeater();

            $repeater->add_control(
                'cat_name', [
					'type'          => Controls_Manager::SELECT,
					'label_block' 	=> true,
					'options' 		=> ellen_toolkit_get_courses_cat_list(),
					'label'         => esc_html__( 'Select Category', 'ellen-toolkit' ),
                ]
            );
            $repeater->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon(for style 1)', 'ellen-toolkit' ),
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'options' => ellen_flaticons(),
				]
            );
            $repeater->add_control(
				'image',
				[
					'label' => esc_html__( 'Icon(for style 2)', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                    'label_block' => true,
				]
            );
            $this->add_control(
                'items',
                [
                    'label'   => esc_html__( 'Add Item', 'ellen-toolkit' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
            );

			$this->add_control(
                'hover_icon',
                [
                    'label' => esc_html__( 'Hover Icon', 'ellen-toolkit' ),
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'options' => ellen_flaticons(),
                ]
            );

			$this->add_control(
                'shape_image',
                [
                    'label' => esc_html__( 'Shape Image', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'bg_color',
				[
					'label' => __( 'Card Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-categories-box, {{WRAPPER}} .rt-categories-box' => 'background-color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'hover_bg_color',
				[
					'label' => __( 'Card Background Color Hover', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-categories-box:hover, {{WRAPPER}} .rt-categories-box' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-categories-box h3, {{WRAPPER}} .rt-categories-box h3' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-categories-box h3, {{WRAPPER}} .rt-categories-box h3',
                ]
            );

			$this->add_control(
				'icon_color',
				[
					'label' => __( 'Icon Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-categories-box .icon' => 'color: {{VALUE}}',
					],
				]
			);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $taxonomy = 'course_category'; // Define the taxonomy
        
        ?>
        <?php if($settings['style'] == '2'): ?>
            <div class="container">
                <div class="row justify-content-center">
                    <?php foreach( $settings['items'] as $item ):
                        // Initialize variables with defaults
                        $cat_link = '#';
                        $cat_name = !empty($item['cat_name']) ? $item['cat_name'] : '';
                        
                        // Only process if we have a category name
                        if (!empty($item['cat_name'])) {
                            $category = get_term_by('slug', $item['cat_name'], $taxonomy);
                            
                            if ($category && !is_wp_error($category)) {
                                $cat_link = get_term_link($category);
                                $cat_name = $category->name;
                            }
                            
                            // Fallback: if term link fails, keep the default '#' and use slug as name
                        }
                        ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="rt-categories-box">
                                <div class="content">
                                    <div class="image-icon">
                                        <?php if(!empty($item['image']['url'])): ?>
                                            <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($cat_name); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <?php if(!empty($cat_name)): ?>
                                        <h3><a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a></h3>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
    
            <?php if(!empty($settings['shape_image']['url'])): ?>
                <div class="shape6"><img src="<?php echo esc_url($settings['shape_image']['url']); ?>" alt="<?php echo esc_attr__('Shape Image', 'ellen-toolkit'); ?>"></div>
            <?php endif; ?>
        <?php else: ?>
            <div class="container">
                <div class="row justify-content-center">
                    <?php foreach( $settings['items'] as $item ):
                        // Initialize variables with defaults
                        $cat_link = '#';
                        $cat_name = !empty($item['cat_name']) ? $item['cat_name'] : '';
                        
                        // Only process if we have a category name
                        if (!empty($item['cat_name'])) {
                            $category = get_term_by('slug', $item['cat_name'], $taxonomy);
                            
                            if ($category && !is_wp_error($category)) {
                                $cat_link = get_term_link($category);
                                $cat_name = $category->name;
                            }
                            
                            // Fallback: if term link fails, keep the default '#' and use slug as name
                        }
                        ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="single-categories-box">
                                <div class="icon">
                                    <i class="<?php echo esc_attr($item['icon']); ?>"></i>
                                </div>
                                <?php if(!empty($cat_name)): ?>
                                    <h3><a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a></h3>
                                    <a href="<?php echo esc_url($cat_link); ?>" class="link-btn"><i class="<?php echo esc_attr($settings['hover_icon']); ?>"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
    
            <?php if(!empty($settings['shape_image']['url'])): ?>
                <div class="shape6"><img src="<?php echo esc_url($settings['shape_image']['url']); ?>" alt="<?php echo esc_attr__('Shape Image', 'ellen-toolkit'); ?>"></div>
            <?php endif; ?>
        <?php endif; ?>
        <?php
    }

}

Plugin::instance()->widgets_manager->register( new Ellen_LP_Categories );