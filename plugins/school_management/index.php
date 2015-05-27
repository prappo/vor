<?php debug_backtrace() || die ("Direct access not permitted."); ?>

<?php
if(function_exists('add_option')) {
	add_option('menu', function(){
		$pdo = db_connect();
		$classes = array();

		foreach($pdo->query("SELECT `class` FROM `scl_students` GROUP BY `class`") as $studentClass) {
			$classes[] = $studentClass['class'];
		}

		add_menu('school_management','School Management','dashboard');

		add_menu('school_principal','School Principal','star');

		add_menu('school_teachers','School Teachers','user-md');
		
		menu_start('','School Students','users');
			if(is_admin()) {
				add_menu('admit_student','Admit New Student','plus-circle');
			}
			add_menu('school_students','All School Students','group');
			foreach($classes as $class) {
				!empty($class) ? add_menu('school_students?class='.strtolower($class), 'Class '.$class, 'dot-circle-o') : null;
			}
		menu_end();

		add_menu('class_routine','Class Routine','calendar');

		add_menu('exam_routine','Exam Routine','align-left');

		add_menu('school_notices','School Notices','file');

	});

	require 'main/import.php';

	$page->a('/admit_student', function(){
			if(is_admin()) {
				require 'main/admitStudent.php';
			} else {
				echo 'Access Denied!';
			}
		}
	);

	$page->a('/school_management', function(){
			require 'main/dashboard.php';
		}
	);

	$page->a('/class_routine', function(){
			require 'main/classRoutine.php';
		}
	);

	$page->a('/exam_routine', function(){
			require 'main/examRoutine.php';
		}
	);

	$page->a('/school_principal', function(){
			require 'main/principal.php';
		}
	);

	$page->a('/school_teachers', function(){
			require 'main/teachers.php';
		}
	);

	$page->a('/school_students', function(){
			require 'main/students.php';
		}
	);

	$page->a('/school_notices', function(){
			require 'main/notices.php';
		}
	);
}