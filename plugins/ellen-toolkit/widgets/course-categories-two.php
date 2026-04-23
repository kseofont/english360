<?php
/**
 * Course Categories Two Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Tutor_Categories_Two extends Widget_Base {

	public function get_name() {
        return 'Ellen_Tutor_Categories_Two';
    }

	public function get_title() {
        return __( 'Course Categories Two', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-post-list';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'two_section',
			[
				'label' => __( 'Categories Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
					'label' => esc_html__( 'Icon', 'ellen-toolkit' ),
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
                'course_title',
                [
                    'label' => esc_html__( 'Total Courses Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
                    'default' 	=> __('Register For Free', 'ellen-toolkit'),
				]
			);

            $this->add_control(
                'link_type',
                [
                    'label' 		=> esc_html__( 'Button Link Type', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' => [
                        '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                        '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                    ],
                    'default' 	=> '1',
                ]
            );

            $this->add_control(
                'link_to_page',
                [
                    'label' 		=> esc_html__( 'Button Link Page', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' 		=> ellen_toolkit_get_page_as_list(),
                    'condition' => [
                        'link_type' => '1',
                    ]
                ]
            );

            $this->add_control(
                'ex_link',
                [
                    'label'		=> esc_html__('Button External Link', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: TEXT,
                    'condition' => [
                        'link_type' => '2',
                    ]
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
						'{{WRAPPER}} .single-categories-item' => 'background-color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'hover_bg_color',
				[
					'label' => __( 'Card Background Color Hover', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-categories-item:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-categories-item h3 a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-categories-item h3 a',
                ]
            );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
        if ($settings['link_type'] == 1 && !empty($settings['link_to_page']) && get_post_status($settings['link_to_page'])) {
            $link = get_page_link( $settings['link_to_page'] );
        }elseif($settings['link_type'] == 2) {
            $link = $settings['ex_link'];
        }else{
            $link = '';
        }
        ?>
            <div class="container">
                <div class="row justify-content-center">
                    <?php foreach( $settings['items'] as $item ):
                        if ( function_exists('tutor') ) {
                            $taxonomy = 'course-category';
                        } elseif( class_exists('LearnPress') ) {
                            $taxonomy = 'course_category';
                        }
                        
                        // Initialize variables with defaults
                        $cat_link = '#';
                        $cat_name = $item['cat_name']; // Fallback to slug if term not found
                        
                        // Only try to get term if cat_name is not empty
                        if (!empty($item['cat_name']) && !empty($taxonomy)) {
                            $category = get_term_by('slug', $item['cat_name'], $taxonomy);
                            if ($category && !is_wp_error($category)) {
                                $cat_link = get_term_link($category);
                                $cat_name = $category->name;
                            }
                        }
                        
                        $args = array(
                            'orderby' => 'slug',
                            'parent' => 0,
                            'taxonomy' => $taxonomy,
                            'field' => 'slug',
                        );
                        ?>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-categories-item">
                                <?php if( !empty($item['icon']['url']) ): ?>
                                    <img src="<?php echo esc_url($item['icon']['url']); ?>" alt="<?php echo esc_attr($cat_name); ?>">
                                <?php endif; ?>
                                <h3><a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a></h3>

                                <?php
                                $categories = get_categories($args);
                                foreach($categories as $category) {
                                    if($category->name == $cat_name): ?>
                                        <span><?php echo ellen_category_post_count($category->name); ?> <?php echo esc_html($settings['course_title']); ?></span>
                                    <?php
                                    endif;
                                }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="categories-btn">
                            <?php if( $settings['button_text'] ): ?>
                                <a href="<?php echo esc_url( $link ); ?>" class="default-btn style-two"><?php echo esc_html( $settings['button_text'] ); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_Tutor_Categories_Two );