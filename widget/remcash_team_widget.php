<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Remcash_Team_Widget extends \Elementor\Widget_Base {

    public function get_name()       { return 'remcash_team'; }
    public function get_title()      { return esc_html__( 'Remcash Team', 'remcash-team' ); }
    public function get_icon()       { return 'eicon-person'; }
    public function get_categories() { return [ 'general' ]; }
    public function get_keywords()   { return [ 'team', 'board', 'members', 'showcase', 'grid', 'people', 'remcash' ]; }

    /* =========================================================
       HELPERS
       ========================================================= */

    /** Build a repeater with the fields shared by both sections */
    private function make_member_repeater() {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control( 'member_image', [
            'label'   => esc_html__( 'Photo', 'remcash-team' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $repeater->add_control( 'member_name', [
            'label'       => esc_html__( 'Name', 'remcash-team' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( 'Full Name', 'remcash-team' ),
            'label_block' => true,
        ] );

        $repeater->add_control( 'member_initials', [
            'label'       => esc_html__( 'Initials (fallback)', 'remcash-team' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => 'AB',
            'label_block' => false,
            'description' => esc_html__( 'Shown when no photo is set.', 'remcash-team' ),
        ] );

        $repeater->add_control( 'member_role', [
            'label'       => esc_html__( 'Role / Position', 'remcash-team' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( 'Role', 'remcash-team' ),
            'label_block' => true,
        ] );

        $repeater->add_control( 'member_bio', [
            'label'   => esc_html__( 'Bio', 'remcash-team' ),
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => esc_html__( 'Enter a short bio here.', 'remcash-team' ),
        ] );

        return $repeater;
    }

    /* =========================================================
       CONTROLS
       ========================================================= */

    protected function register_controls() {

        /* ── BOARD members ─────────────────────────────────── */
        $this->start_controls_section( 'board_section', [
            'label' => esc_html__( 'Board Members', 'remcash-team' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'board_label', [
            'label'       => esc_html__( 'Section Title', 'remcash-team' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( 'Our People – The Board', 'remcash-team' ),
            'label_block' => true,
        ] );

        $this->add_control( 'board_members', [
            'label'       => esc_html__( 'Board Members', 'remcash-team' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $this->make_member_repeater()->get_controls(),
            'default'     => [
                [ 'member_name' => 'Louis Josiah',    'member_role' => 'Chairman of the Board', 'member_initials' => 'LJ' ],
                [ 'member_name' => 'Felix Quaicoe',   'member_role' => 'Managing Director',     'member_initials' => 'FQ' ],
                [ 'member_name' => 'Damaris Tanoe Rivers', 'member_role' => 'Secretary',        'member_initials' => 'DT' ],
                [ 'member_name' => 'Emmanuel Egyei-Mensah', 'member_role' => 'Member',          'member_initials' => 'EE' ],
            ],
            'title_field' => '{{{ member_name }}}',
        ] );

        $this->end_controls_section();

        /* ── TEAM members ─────────────────────────────────── */
        $this->start_controls_section( 'team_section', [
            'label' => esc_html__( 'Team Members', 'remcash-team' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'team_label', [
            'label'       => esc_html__( 'Section Title', 'remcash-team' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( 'Our People – The Team', 'remcash-team' ),
            'label_block' => true,
        ] );

        $this->add_control( 'team_members', [
            'label'       => esc_html__( 'Team Members', 'remcash-team' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $this->make_member_repeater()->get_controls(),
            'default'     => [
                [ 'member_name' => 'Pearl Dumenu',  'member_role' => 'Manager', 'member_initials' => 'PD' ],
                [ 'member_name' => 'Daniel Zewu',   'member_role' => 'Role',    'member_initials' => 'DZ' ],
                [ 'member_name' => 'Chris Nordjo',  'member_role' => 'Role',    'member_initials' => 'CN' ],
            ],
            'title_field' => '{{{ member_name }}}',
        ] );

        $this->end_controls_section();

        /* ── LAYOUT ────────────────────────────────────────── */
        $this->start_controls_section( 'layout_section', [
            'label' => esc_html__( 'Layout', 'remcash-team' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_responsive_control( 'columns', [
            'label'          => esc_html__( 'Columns', 'remcash-team' ),
            'type'           => \Elementor\Controls_Manager::SELECT,
            'default'        => '4',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options'        => [ '1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6' ],
            'selectors'      => [
                '{{WRAPPER}} .rct-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => esc_html__( 'Gap', 'remcash-team' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 16 ],
            'selectors'  => [ '{{WRAPPER}} .rct-grid' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        /* ── STYLE: Card ──────────────────────────────────── */
        $this->start_controls_section( 'card_style', [
            'label' => esc_html__( 'Card', 'remcash-team' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_bg', [
            'label'     => esc_html__( 'Background', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .rct-card' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'card_border_color', [
            'label'     => esc_html__( 'Border Color', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#e5e5e5',
            'selectors' => [ '{{WRAPPER}} .rct-card' => 'border-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'card_hover_border_color', [
            'label'     => esc_html__( 'Hover Border Color', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#2C6DDB',
            'selectors' => [ '{{WRAPPER}} .rct-card:hover' => 'border-color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'card_radius', [
            'label'      => esc_html__( 'Border Radius', 'remcash-team' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 10 ],
            'selectors'  => [ '{{WRAPPER}} .rct-card' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'image_height', [
            'label'      => esc_html__( 'Photo Height', 'remcash-team' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 80, 'max' => 600 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 285 ],
            'selectors'  => [
                '{{WRAPPER}} .rct-card img'      => 'height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .rct-card-initials' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        /* ── STYLE: Section Title ─────────────────────────── */
        $this->start_controls_section( 'title_style', [
            'label' => esc_html__( 'Section Title', 'remcash-team' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'title_color', [
            'label'     => esc_html__( 'Color', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#333333',
            'selectors' => [ '{{WRAPPER}} .rct-section-label' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .rct-section-label',
            'default'  => [
                'font_size' => [ 'unit' => 'px', 'size' => 30 ],
                'font_weight' => '600',
                'color' => '#333333',
            ],
        ] );

        $this->end_controls_section();

        /* ── STYLE: Name & Role ───────────────────────────── */
        $this->start_controls_section( 'name_style', [
            'label' => esc_html__( 'Card Name & Role', 'remcash-team' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'name_color', [
            'label'     => esc_html__( 'Name Color', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#333333',
            'selectors' => [ '{{WRAPPER}} .rct-card-name' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'role_color', [
            'label'     => esc_html__( 'Role Color', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#2C6DDB',
            'selectors' => [ '{{WRAPPER}} .rct-card-role' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'card_name_typography',
            'label'    => esc_html__( 'Name Typography', 'remcash-team' ),
            'selector' => '{{WRAPPER}} .rct-card-name',
            'default'  => [
                'font_size' => [ 'unit' => 'px', 'size' => 16 ],
                'font_weight' => '600',
                'color' => '#333333',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'card_role_typography',
            'label'    => esc_html__( 'Role Typography', 'remcash-team' ),
            'selector' => '{{WRAPPER}} .rct-card-role',
            'default'  => [
                'font_size' => [ 'unit' => 'px', 'size' => 14 ],
                'font_weight' => '500',
                'color' => '#2C6DDB',
            ],
        ] );

        $this->add_control( 'card_text_spacing_heading', [
            'label'     => esc_html__( 'Text Spacing', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_responsive_control( 'card_name_margin', [
            'label'      => esc_html__( 'Name Margin', 'remcash-team' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default'    => [
                'top'    => 8,
                'right'  => 0,
                'bottom' => 0,
                'left'   => 0,
            ],
            'selectors'  => [ '{{WRAPPER}} .rct-card-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'card_role_margin', [
            'label'      => esc_html__( 'Role Margin', 'remcash-team' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default'    => [
                'top'    => 2,
                'right'  => 0,
                'bottom' => 0,
                'left'   => 0,
            ],
            'selectors'  => [ '{{WRAPPER}} .rct-card-role' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        /* ── STYLE: Popup ─────────────────────────────────── */
        $this->start_controls_section( 'popup_style', [
            'label' => esc_html__( 'Popup', 'remcash-team' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'popup_overlay_color', [
            'label'     => esc_html__( 'Overlay Color', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(0,0,0,0.55)',
            'selectors' => [ '{{WRAPPER}} .rct-overlay' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'popup_bg', [
            'label'     => esc_html__( 'Popup Background', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .rct-popup' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'popup_accent_color', [
            'label'     => esc_html__( 'Role Accent Color', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#2C6DDB',
            'selectors' => [
                '{{WRAPPER}} .rct-popup-role'       => 'color: {{VALUE}};',
                '{{WRAPPER}} .rct-other-role'       => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'popup_typography_heading', [
            'label'     => esc_html__( 'Typography', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'popup_name_typography',
            'label'    => esc_html__( 'Name Typography', 'remcash-team' ),
            'selector' => '{{WRAPPER}} .rct-popup-name',
            'default'  => [
                'font_size' => [ 'unit' => 'px', 'size' => 30 ],
                'font_weight' => '600',
                'color' => '#333333',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'popup_role_typography',
            'label'    => esc_html__( 'Role Typography', 'remcash-team' ),
            'selector' => '{{WRAPPER}} .rct-popup-role',
            'default'  => [
                'font_size' => [ 'unit' => 'px', 'size' => 14 ],
                'font_weight' => '500',
                'color' => '#2C6DDB',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'popup_bio_typography',
            'label'    => esc_html__( 'Bio Typography', 'remcash-team' ),
            'selector' => '{{WRAPPER}} .rct-popup-bio, {{WRAPPER}} .rct-popup-bio *',
            'default'  => [
                'font_size' => [ 'unit' => 'px', 'size' => 14 ],
                'color' => '#000000',
                'line_height' => [ 'unit' => 'em', 'size' => 1.7 ],
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'popup_others_label_typography',
            'label'    => esc_html__( 'Others Label Typography', 'remcash-team' ),
            'selector' => '{{WRAPPER}} .rct-others-label',
            'default'  => [
                'font_size' => [ 'unit' => 'px', 'size' => 22 ],
                'font_weight' => '600',
                'color' => '#333333',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'popup_others_name_typography',
            'label'    => esc_html__( 'Other Members Name Typography', 'remcash-team' ),
            'selector' => '{{WRAPPER}} .rct-other-name',
            'default'  => [
                'font_size' => [ 'unit' => 'px', 'size' => 13 ],
                'font_weight' => '600',
                'color' => '#333333',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'popup_others_role_typography',
            'label'    => esc_html__( 'Other Members Role Typography', 'remcash-team' ),
            'selector' => '{{WRAPPER}} .rct-other-role',
            'default'  => [
                'font_size' => [ 'unit' => 'px', 'size' => 12 ],
                'font_weight' => '500',
                'color' => '#2C6DDB',
            ],
        ] );

        $this->add_control( 'popup_others_spacing_heading', [
            'label'     => esc_html__( 'Other Members Text Spacing', 'remcash-team' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_responsive_control( 'popup_other_name_margin', [
            'label'      => esc_html__( 'Name Margin', 'remcash-team' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default'    => [
                'top'    => 8,
                'right'  => 0,
                'bottom' => 0,
                'left'   => 0,
            ],
            'selectors'  => [ '{{WRAPPER}} .rct-other-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'popup_other_role_margin', [
            'label'      => esc_html__( 'Role Margin', 'remcash-team' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default'    => [
                'top'    => 2,
                'right'  => 0,
                'bottom' => 0,
                'left'   => 0,
            ],
            'selectors'  => [ '{{WRAPPER}} .rct-other-role' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    /* =========================================================
       RENDER
       ========================================================= */

    protected function render() {
        $settings  = $this->get_settings_for_display();
        $widget_id = $this->get_id();

        $board_members = ! empty( $settings['board_members'] ) ? $settings['board_members'] : [];
        $team_members  = ! empty( $settings['team_members'] )  ? $settings['team_members']  : [];

        if ( empty( $board_members ) && empty( $team_members ) ) {
            return;
        }

        // Build a combined indexed list (group + index stored in data attrs)
        $board_label = ! empty( $settings['board_label'] ) ? $settings['board_label'] : 'Our People – The Board';
        $team_label  = ! empty( $settings['team_label'] )  ? $settings['team_label']  : 'Our People – The Team';
        ?>

        <div class="rct-wrapper" data-widget-id="<?php echo esc_attr( $widget_id ); ?>">

            <?php if ( ! empty( $board_members ) ) : ?>
            <div class="rct-section">
                <div class="rct-section-label"><?php echo esc_html( $board_label ); ?></div>
                <div class="rct-grid">
                    <?php foreach ( $board_members as $idx => $m ) : ?>
                        <div class="rct-card-wrap" data-group="board" data-index="<?php echo esc_attr( $idx ); ?>">
                            <?php $this->render_card( $m ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ( ! empty( $team_members ) ) : ?>
            <div class="rct-section" style="margin-top:2rem;">
                <div class="rct-section-label"><?php echo esc_html( $team_label ); ?></div>
                <div class="rct-grid">
                    <?php foreach ( $team_members as $idx => $m ) : ?>
                        <div class="rct-card-wrap" data-group="team" data-index="<?php echo esc_attr( $idx ); ?>">
                            <?php $this->render_card( $m ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Overlay / Popup -->
            <div class="rct-overlay" id="rct-overlay-<?php echo esc_attr( $widget_id ); ?>">
                <div class="rct-popup">

                    <!-- Left: photo -->
                    <div class="rct-popup-left" id="rct-photo-<?php echo esc_attr( $widget_id ); ?>"></div>

                    <!-- Right: details -->
                    <div class="rct-popup-right">
                        <div class="rct-popup-header">
                            <div>
                                <h2 class="rct-popup-name" id="rct-pname-<?php echo esc_attr( $widget_id ); ?>"></h2>
                                <p class="rct-popup-role" id="rct-prole-<?php echo esc_attr( $widget_id ); ?>"></p>
                            </div>
                            <button class="rct-close-btn" id="rct-close-<?php echo esc_attr( $widget_id ); ?>">&#x2715;</button>
                        </div>
                        <div class="rct-popup-bio" id="rct-pbio-<?php echo esc_attr( $widget_id ); ?>"></div>
                        <p class="rct-others-label" id="rct-others-label-<?php echo esc_attr( $widget_id ); ?>"></p>
                        <div class="rct-others-grid" id="rct-others-<?php echo esc_attr( $widget_id ); ?>"></div>
                    </div>

                </div>
            </div>

        </div><!-- .rct-wrapper -->

        <!-- Inline JSON data for JS -->
        <script type="application/json" id="rct-data-<?php echo esc_attr( $widget_id ); ?>">
            <?php
            $data = [
                'board' => $this->prepare_members_for_js( $board_members ),
                'team'  => $this->prepare_members_for_js( $team_members ),
            ];
            echo wp_json_encode( $data );
            ?>
        </script>

        <?php
    }

    /** Strip down to what JS needs */
    private function prepare_members_for_js( $members ) {
        $out = [];
        foreach ( $members as $m ) {
            $out[] = [
                'name'     => isset( $m['member_name'] )     ? $m['member_name']     : '',
                'initials' => isset( $m['member_initials'] ) ? $m['member_initials'] : '',
                'role'     => isset( $m['member_role'] )     ? $m['member_role']     : '',
                'bio'      => isset( $m['member_bio'] )      ? $m['member_bio']      : '',
                'img'      => isset( $m['member_image']['url'] ) ? $m['member_image']['url'] : '',
            ];
        }
        return $out;
    }

    private function render_card( $m ) {
        $img_url  = isset( $m['member_image']['url'] ) ? $m['member_image']['url'] : '';
        $initials = isset( $m['member_initials'] ) ? esc_html( $m['member_initials'] ) : '';
        $name     = isset( $m['member_name'] ) ? esc_html( $m['member_name'] ) : '';
        $role     = isset( $m['member_role'] ) ? esc_html( $m['member_role'] ) : '';
        ?>
        <div class="rct-card">
            <?php if ( $img_url ) : ?>
                <img src="<?php echo esc_url( $img_url ); ?>"
                     alt="<?php echo $name; ?>"
                     onerror="this.outerHTML='<div class=\'rct-card-initials\'><?php echo $initials; ?></div>'">
            <?php else : ?>
                <div class="rct-card-initials"><?php echo $initials; ?></div>
            <?php endif; ?>
            <div class="rct-card-info">
                <h3 class="rct-card-name"><?php echo $name; ?></h3>
                <p  class="rct-card-role"><?php echo $role; ?></p>
            </div>
        </div>
        <?php
    }
}
