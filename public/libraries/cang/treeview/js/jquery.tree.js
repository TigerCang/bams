/**
 * Theme: Uplon Admin Template
 * Author: Coderthemes
 * Tree view
 */

$( document ).ready(function() {
    // Basic
    $('#basicTree').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'default' : {
                'icon' : 'icofont icofont-folder'
            },
            'file' : {
                'icon' : 'icofont icofont-file-alt'
            }
        },
        'plugins' : ['types']
    });
    
    // Checkbox
    // $('#checkTree').jstree({
	// 	'core' : {
	// 		'themes' : {
	// 			'responsive': false
	// 		}
	// 	},
    //     'types' : {
    //         'default' : {
    //             'icon' : 'icofont icofont-folder'
    //         },
    //         'file' : {
    //             'icon' : 'icofont icofont-file-alt'
    //         }
    //     },
    //     'plugins' : ['types', 'checkbox']
    // });
    
    // Checkbox
    $('#checkTree1').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            // 'default' : {
            //     'icon' : 'icofont icofont-ui-folder'
            // },
            'file' : {
                'icon' : 'icofont icofont-file-php'
            }
        },
        'plugins' : ['types', 'checkbox']
    });

    $('#checkTree2').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'file' : {
                'icon' : 'icofont icofont-file-php'
            }
        },
        'plugins' : ['types', 'checkbox']
    });

    $('#checkTree3').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'file' : {
                'icon' : 'icofont icofont-file-php'
            }
        },
        'plugins' : ['types', 'checkbox']
    });

    $('#checkTree4').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'file' : {
                'icon' : 'icofont icofont-file-php'
            }
        },
        'plugins' : ['types', 'checkbox']
    });

    $('#checkTree5').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'file' : {
                'icon' : 'icofont icofont-file-php'
            }
        },
        'plugins' : ['types', 'checkbox']
    });

    $('#checkTree6').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'file' : {
                'icon' : 'icofont icofont-file-php'
            }
        },
        'plugins' : ['types', 'checkbox']
    });

    $('#checkTree7').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'file' : {
                'icon' : 'icofont icofont-file-php'
            }
        },
        'plugins' : ['types', 'checkbox']
    });

    $('#checkTree8').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'file' : {
                'icon' : 'icofont icofont-file-php'
            }
        },
        'plugins' : ['types', 'checkbox']
    });

    // Drag & Drop
    $('#dragTree').jstree({
		'core' : {
			'check_callback' : true,
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'default' : {
                'icon' : 'icofont icofont-folder'
            },
            'file' : {
                'icon' : 'icofont icofont-file-alt'
            }
        },
        'plugins' : ['types', 'dnd']
    });
    
    // Ajax
    $('#ajaxTree').jstree({
		'core' : {
			'check_callback' : true,
			'themes' : {
				'responsive': false
			},
            'data' : {
                'url' : function (node) {
                    return node.id === '#' ? 'assets/plugins/jstree/ajax_roots.json' : 'assets/plugins/jstree/ajax_children.json';
                },
                'data' : function (node) {
                    return { 'id' : node.id };
                }
            }
        },
        "types" : {
            'default' : {
                'icon' : 'icofont icofont-folder'
            },
            'file' : {
                'icon' : 'icofont icofont-file-alt'
            }
        },
        "plugins" : [ "contextmenu", "dnd", "search", "state", "types", "wholerow" ]
    });
});