(function ($) {
    'use strict';

    class RemcashTeam {

        constructor(wrapper) {
            this.$wrapper  = $(wrapper);
            this.widgetId  = this.$wrapper.data('widget-id');
            this.$overlay  = $('#rct-overlay-'        + this.widgetId);
            this.$photo    = $('#rct-photo-'           + this.widgetId);
            this.$name     = $('#rct-pname-'           + this.widgetId);
            this.$role     = $('#rct-prole-'           + this.widgetId);
            this.$bio      = $('#rct-pbio-'            + this.widgetId);
            this.$othLabel = $('#rct-others-label-'    + this.widgetId);
            this.$othGrid  = $('#rct-others-'          + this.widgetId);

            this.data = { board: [], team: [] };
            this.init();
        }

        init() {
            this.loadData();
            this.bindEvents();
        }

        loadData() {
            const $script = $('#rct-data-' + this.widgetId);
            if ($script.length) {
                try {
                    this.data = JSON.parse($script.text());
                } catch (e) {
                    console.error('RemcashTeam: could not parse team data', e);
                }
            }
        }

        bindEvents() {
            // Open on card-wrap click
            this.$wrapper.find('.rct-card-wrap').on('click', (e) => {
                const $wrap = $(e.currentTarget);
                const group = $wrap.data('group');   // 'board' | 'team'
                const index = parseInt($wrap.data('index'), 10);
                this.openPopup(group, index);
            });

            // Close button
            $('#rct-close-' + this.widgetId).on('click', () => this.closePopup());

            // Click outside popup
            this.$overlay.on('click', (e) => {
                if ($(e.target).is(this.$overlay)) {
                    this.closePopup();
                }
            });

            // Keyboard
            $(document).on('keydown.rct-' + this.widgetId, (e) => {
                if (this.$overlay.hasClass('active') && e.key === 'Escape') {
                    this.closePopup();
                }
            });
        }

        openPopup(group, index) {
            const members = this.data[group] || [];
            const member  = members[index];
            if (!member) return;

            // ── Photo ──
            const initials = member.initials || this.getInitials(member.name);
            if (member.img) {
                this.$photo.html(
                    `<img src="${this.esc(member.img)}" alt="${this.esc(member.name)}"
                          onerror="this.outerHTML='<div class=\\'rct-popup-left-initials\\'>${this.esc(initials)}</div>'">`
                );
            } else {
                this.$photo.html(`<div class="rct-popup-left-initials">${this.esc(initials)}</div>`);
            }

            // ── Text ──
            this.$name.text(member.name || '');
            this.$role.text(member.role || '');
            this.$bio.html(member.bio  || '');

            // ── Other members in same group ──
            const groupLabel = group === 'board' ? 'Board' : 'Team';
            this.$othLabel.text('Other ' + groupLabel + ' Members');
            this.$othGrid.empty();

            members.forEach((m, i) => {
                if (i === index) return;
                const mInitials = m.initials || this.getInitials(m.name);
                const photoHtml = m.img
                    ? `<img src="${this.esc(m.img)}" alt="${this.esc(m.name)}"
                             onerror="this.outerHTML='<div class=\\'rct-other-initials\\'>${this.esc(mInitials)}</div>'">`
                    : `<div class="rct-other-initials">${this.esc(mInitials)}</div>`;

                const $card = $('<div class="rct-other-card"></div>').html(`
                    ${photoHtml}
                    <p class="rct-other-name">${this.esc(m.name)}</p>
                    <p class="rct-other-role">${this.esc(m.role)}</p>
                `);

                $card.on('click', () => this.openPopup(group, i));
                this.$othGrid.append($card);
            });

            // ── Show ──
            this.$overlay.addClass('active');
            $('body').css('overflow', 'hidden');
        }

        closePopup() {
            this.$overlay.removeClass('active');
            $('body').css('overflow', '');
        }

        getInitials(name) {
            if (!name) return '?';
            return name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
        }

        esc(str) {
            if (!str) return '';
            const map = { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' };
            return String(str).replace(/[&<>"']/g, m => map[m]);
        }
    }

    // ── Boot ──────────────────────────────────────────────────

    function initAll($scope) {
        $scope.find('.rct-wrapper').each(function () {
            if (!$(this).data('rct-init')) {
                $(this).data('rct-init', true);
                new RemcashTeam(this);
            }
        });
    }

    // Elementor frontend
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/remcash_team.default',
            function ($scope) { initAll($scope); }
        );
    });

    // Fallback / non-Elementor
    $(document).ready(function () {
        initAll($(document.body));
    });

})(jQuery);
