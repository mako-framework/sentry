<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config)->setRules
([
	'align_multiline_comment' => true,
	'array_syntax' => ['syntax' => 'short'],
	'blank_line_after_namespace' => true,
	'blank_line_after_opening_tag' => true,
	'cast_spaces' => true,
	'combine_nested_dirname' => true,
	'concat_space' => ['spacing' => 'one'],
	'constant_case' => true,
	'elseif' => true,
	'encoding' => true,
	'full_opening_tag' => true,
	'function_declaration' => true,
	'function_to_constant' => true,
	'function_typehint_space' => true,
	'heredoc_to_nowdoc' => true,
	'linebreak_after_opening_tag' => true,
	'list_syntax' => ['syntax' => 'short'],
	'logical_operators' => true,
	'lowercase_cast' => true,
	'lowercase_keywords' => true,
	'lowercase_static_reference' => true,
	'magic_constant_casing' => true,
	'magic_method_casing' => true,
	'method_argument_space' => ['on_multiline' => 'ignore'],
	'native_function_casing' => true,
	'native_function_type_declaration_casing' => true,
	'no_alias_functions' => true,
	'no_blank_lines_after_phpdoc' => true,
	'no_closing_tag' => true,
	'no_empty_statement' => true,
	'no_extra_blank_lines' => true,
	'no_leading_import_slash' => true,
	'no_leading_namespace_whitespace' => true,
	'no_singleline_whitespace_before_semicolons' => true,
	'no_spaces_inside_parenthesis' => true,
	'no_trailing_comma_in_list_call' => true,
	'no_trailing_comma_in_singleline_array' => true,
	'no_trailing_whitespace_in_comment' => true,
	'no_trailing_whitespace' => true,
	'no_unset_cast' => true,
	'no_unused_imports' => true,
	'no_useless_sprintf' => true,
	'no_whitespace_before_comma_in_array' => true,
	'no_whitespace_in_blank_line' => true,
	'non_printable_character' => true,
	'normalize_index_brace' => true,
	'nullable_type_declaration_for_default_null_value' => true,
	'object_operator_without_whitespace' => true,
	'ordered_imports' => ['imports_order' => ['class', 'function', 'const']],
	'ordered_traits' => true,
	'phpdoc_align' => true,
	'phpdoc_annotation_without_dot' => true,
	'phpdoc_indent' => true,
	'phpdoc_no_access' => true,
	'phpdoc_no_empty_return' => true,
	'phpdoc_order' => true,
	'phpdoc_scalar' => true,
	'phpdoc_single_line_var_spacing' => true,
	'phpdoc_summary' => true,
	'phpdoc_tag_casing' => true,
	'phpdoc_to_comment' => ['ignored_tags' => ['var']],
	'phpdoc_trim' => true,
	'phpdoc_types_order' => ['sort_algorithm' => 'alpha', 'null_adjustment' => 'always_last'],
	'phpdoc_types' => true,
	'pow_to_exponentiation' => true,
	'return_type_declaration' => true,
	'short_scalar_cast' => true,
	'simple_to_complex_string_variable' => true,
	'single_blank_line_at_eof' => true,
	'single_blank_line_before_namespace' => true,
	'single_import_per_statement' => true,
	'single_line_after_imports' => true,
	'single_line_comment_style' => ['comment_types' => ['hash']],
	'single_quote' => true,
	'space_after_semicolon' => true,
	'standardize_not_equals' => true,
	'switch_case_semicolon_to_colon' => true,
	'switch_case_space' => true,
	'trailing_comma_in_multiline' => ['elements' => ['arrays', 'match']],
	'trim_array_spaces' => true,
	'visibility_required' => true,
	'void_return' => true,
	'whitespace_after_comma_in_array' => true,
])
->setRiskyAllowed(true)
->setFinder((new Finder)->in(__DIR__));
