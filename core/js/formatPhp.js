/* PHP arrays */

var phpRedWarningArr = {
	0:"PHP Fatal",
	1:"PHP Parse error",
	2:"PHP Syntax error"
};

var phpYellowWarningArr = {
	0:"PHP Warning"
};

var parseTokenWeight = 10;

var phpInfoArr = {
	0: {
		syntax: "abstract",
		target: "T_ABSTRACT",
		weight: parseTokenWeight,
		define: "PHP 5 introduces abstract classes and methods. Classes defined as abstract may not be instantiated, and any class that contains at least one abstract method must also be abstract. Methods defined as abstract simply declare the method's signature - they cannot define the implementation.",
		more: "When inheriting from an abstract class, all methods marked abstract in the parent's class declaration must be defined by the child; additionally, these methods must be defined with the same (or a less restricted) visibility. For example, if the abstract method is defined as protected, the function implementation must be defined as either protected or public, but not private. Furthermore the signatures of the methods must match, i.e. the type hints and the number of required arguments must be the same. For example, if the child class defines an optional argument, where the abstract method's signature does not, there is no conflict in the signature. This also applies to constructors as of PHP 5.4. Before 5.4 constructor signatures could differ.",
		link: "php.net/manual/en/language.oop5.abstract.php"
	},
	1: {
		syntax: "&=",
		target: "T_AND_EQUAL",
		weight: parseTokenWeight,
		define: "The basic assignment operator is \"=\". Your first inclination might be to think of this as \"equal to\". Don't. It really means that the left operand gets set to the value of the expression on the right (that is, \"gets set to\").",
		more: "he value of an assignment expression is the value assigned. That is, the value of \"$a = 3\" is 3. In addition to the basic assignment operator, there are \"combined operators\" for all of the binary arithmetic, array union and string operators that allow you to use a value in an expression and then set its value to the result of that expression",
		link: "php.net/manual/en/language.operators.assignment.php"
	},
	2: {
		syntax: "array()",
		target: "T_ARRAY",
		weight: parseTokenWeight,
		define: "An array can be created using the array() language construct. It takes any number of comma-separated key => value pairs as arguments.",
		more: "The comma after the last array element is optional and can be omitted. This is usually done for single-line arrays, i.e. array(1, 2) is preferred over array(1, 2, ). For multi-line arrays on the other hand the trailing comma is commonly used, as it allows easier addition of new elements at the end. As of PHP 5.4 you can also use the short array syntax, which replaces array() with [].",
		link: "php.net/manual/en/language.types.array.php#language.types.array.syntax"
	},
	3: {
		syntax: "(array)",
		target: "T_ARRAY_CAST",
		weight: parseTokenWeight,
		define: "Type casting in PHP works much as it does in C: the name of the desired type is written in parentheses before the variable which is to be cast. (array) would cast to array.",
		more: "For any of the types integer, float, string, boolean and resource, converting a value to an array results in an array with a single element with index zero and the value of the scalar which was converted. In other words, (array)$scalarValue is exactly the same as array($scalarValue).If an object is converted to an array, the result is an array whose elements are the object's properties. The keys are the member variable names, with a few notable exceptions: integer properties are unaccessible; private variables have the class name prepended to the variable name; protected variables have a '*' prepended to the variable name. These prepended values have null bytes on either side.",
		link: "php.net/manual/en/language.types.array.php"
	},
	4: {
		syntax: "as",
		target: "T_AS",
		weight: parseTokenWeight,
		define: "<pre>foreach (array_expression as $value) </pre><pre>foreach (array_expression as $key =&gt; $value)</pre>",
		more: "The foreach construct provides an easy way to iterate over arrays. foreach works only on arrays and objects, and will issue an error when you try to use it on a variable with a different data type or an uninitialized variable. The first form loops over the array given by array_expression. On each iteration, the value of the current element is assigned to $value and the internal array pointer is advanced by one (so on the next iteration, you'll be looking at the next element).The second form will additionally assign the current element's key to the $key variable on each iteration.",
		link: "php.net/manual/en/control-structures.foreach.php"
	},
	5: {
		syntax: "",
		target: "T_BAD_CHARACTER",
		weight: parseTokenWeight,
		define: "anything below ASCII 32 except \\t (0x09), \\n (0x0a) and \\r (0x0d)",
		more: "",
		link: "php.net/tokens"
	},
	6: {
		syntax: "&&",
		target: "T_BOOLEAN_AND",
		weight: parseTokenWeight,
		define: "$a && $b: TRUE if both $a and $b are TRUE",
		more: "$a and $b is another form of \"and\" but will operate at different precedences. (after && and =)",
		link: "php.net/manual/en/language.operators.logical.php",
		link2: "php.net/manual/en/language.operators.precedence.php"
	},
	7: {
		syntax: "||",
		target: "T_BOOLEAN_OR",
		weight: parseTokenWeight,
		define: "$a || $b: TRUE if either $a or $b is TRUE.",
		more: "$a or $b is another form of \"or\" but will operate at different precedences. (after || and =)",
		link: "php.net/manual/en/language.operators.logical.php",
		link2: "php.net/manual/en/language.operators.precedence.php"
	},
	8: {
		syntax: "(bool), (boolean)",
		target: "T_BOOL_CAST",
		weight: parseTokenWeight,
		define: "Type casting in PHP works much as it does in C: the name of the desired type is written in parentheses before the variable which is to be cast. (bool), (boolean) - cast to boolean",
		more: "To explicitly convert a value to boolean, use the (bool) or (boolean) casts. However, in most cases the cast is unnecessary, since a value will be automatically converted if an operator, function or control structure requires a boolean argument.When converting to boolean, the following values are considered FALSE: <ul><li>the boolean FALSE itself</li><li>the integer 0 (zero)</li><li>the float 0.0 (zero)</li><li>the empty string, and the string \"0\"</li><li>an array with zero elements</li><li>the special type NULL (including unset variables)</li><li>SimpleXML objects created from empty tags</li></ul>",
		link: "php.net/manual/en/language.types.boolean.php#language.types.boolean.casting"
	},
	9: {
		syntax: "break",
		target: "T_BREAK",
		weight: parseTokenWeight,
		define: "break ends execution of the current for, foreach, while, do-while or switch structure.",
		more: "break accepts an optional numeric argument which tells it how many nested enclosing structures are to be broken out of. The default value is 1, only the immediate enclosing structure is broken out of.",
		link: "php.net/manual/en/control-structures.break.php"
	},
	10: {
		syntax: "callable",
		target: "T_CALLABLE",
		weight: parseTokenWeight,
		define: "Callbacks can be denoted by callable type hint as of PHP 5.4. This documentation used callback type information for the same purpose.Some functions like call_user_func() or usort() accept user-defined callback functions as a parameter. Callback functions can not only be simple functions, but also object methods, including static class methods.",
		more: "",
		link: "php.net/manual/en/language.types.callable.php"
	},
	11: {
		syntax: "case",
		target: "T_CASE",
		weight: parseTokenWeight,
		define: "The switch statement is similar to a series of IF statements on the same expression. In many occasions, you may want to compare the same variable (or expression) with many different values, and execute a different piece of code depending on which value it equals to. This is exactly what the switch statement is for.",
		more: "It is important to understand how the switch statement is executed in order to avoid mistakes. The switch statement executes line by line (actually, statement by statement). In the beginning, no code is executed. Only when a case statement is found whose expression evaluates to a value that matches the value of the switch expression does PHP begin to execute the statements. PHP continues to execute the statements until the end of the switch block, or the first time it sees a break statement. If you don't write a break statement at the end of a case's statement list, PHP will go on executing the statements of the following case",
		link: "php.net/manual/en/control-structures.switch.php"
	},
	12: {
		syntax: "catch",
		target: "T_CATCH",
		weight: parseTokenWeight,
		define: "Multiple catch blocks can be used to catch different classes of exceptions. Normal execution (when no exception is thrown within the try block) will continue after that last catch block defined in sequence. Exceptions can be thrown (or re-thrown) within a catch block.",
		more: "When an exception is thrown, code following the statement will not be executed, and PHP will attempt to find the first matching catch block. If an exception is not caught, a PHP Fatal Error will be issued with an \"Uncaught Exception ...\" message, unless a handler has been defined with set_exception_handler().In PHP 7.1 and later, a catch block may specify multiple exceptions using the pipe (|) character. This is useful for when different exceptions from different class hierarchies are handled the same.",
		link: "php.net/manual/en/language.exceptions.php"
	},
	13: {
		syntax: "",
		target: "T_CHARACTER",
		weight: parseTokenWeight,
		define: "This shouldn't be used anymore. If you get this error, you should probably upgrade your version of php?",
		more: "",
		link: ""
	},
	14: {
		syntax: "class",
		target: "T_CLASS",
		weight: parseTokenWeight,
		define: "Basic class definitions begin with the keyword class, followed by a class name, followed by a pair of curly braces which enclose the definitions of the properties and methods belonging to the class.",
		more: "The class name can be any valid label, provided it is not a PHP reserved word. A valid class name starts with a letter or underscore, followed by any number of letters, numbers, or underscores. As a regular expression, it would be expressed thus: ^[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*$.A class may contain its own constants, variables (called \"properties\"), and functions (called \"methods\").",
		link: "php.net/manual/en/language.oop5.php"
	},
	15: {
		syntax: "__CLASS__",
		target: "T_CLASS_C",
		weight: parseTokenWeight,
		define: "The class name. The class name includes the namespace it was declared in (e.g. Foo\\Bar). Note that as of PHP 5.4 __CLASS__ works also in traits. When used in a trait method, __CLASS__ is the name of the class the trait is used in.",
		more: "PHP provides a large number of predefined constants to any script which it runs. Many of these constants, however, are created by various extensions, and will only be present when those extensions are available, either via dynamic loading or because they have been compiled in.",
		link: "php.net/manual/en/language.constants.predefined.php"
	},
	16: {
		syntax: "clone",
		target: "T_CLONE",
		weight: parseTokenWeight,
		define: "An object copy is created by using the clone keyword (which calls the object's __clone() method if possible). An object's __clone() method cannot be called directly. <pre>$copy_of_object = clone $object; </pre>When an object is cloned, PHP will perform a shallow copy of all of the object's properties. Any properties that are references to other variables will remain references.",
		more: "",
		link: "php.net/manual/en/language.oop5.cloning.php"
	},
	17: {
		syntax: "?>, %>",
		target: "T_CLOSE_TAG",
		weight: parseTokenWeight,
		define: "Everything outside of a pair of opening and closing tags is ignored by the PHP parser which allows PHP files to have mixed content. This allows PHP to be embedded in HTML documents, for example to create templates.",
		more: "When the PHP interpreter hits the ?> closing tags, it simply starts outputting whatever it finds (with some exceptions) until it hits another opening tag unless in the middle of a conditional statement in which case the interpreter will determine the outcome of the conditional before making a decision of what to skip over",
		link: "php.net/manual/en/language.basic-syntax.phpmode.php"
	},
	18: {
		syntax: "??",
		target: "T_COALESCE",
		weight: parseTokenWeight,
		define: "The expression (expr1) ?? (expr2) evaluates to expr2 if expr1 is NULL, and expr1 otherwise. In particular, this operator does not emit a notice if the left-hand side value does not exist, just like isset(). This is especially useful on array keys.",
		more: "Added in php 7, and allows for simple nesting",
		link: "php.net/manual/en/language.operators.comparison.php#language.operators.comparison.coalesce"
	},
	19: {
		syntax: "//, #, /* */",
		target: "T_COMMENT",
		weight: parseTokenWeight,
		define: "The // or # comment styles only comment to the end of the line or the current block of PHP code, whichever comes first. This means that HTML code after // ... ?> or # ... ?> WILL be printed: ?> breaks out of PHP mode and returns to HTML mode, and // or # cannot influence that. If the asp_tags configuration directive is enabled, it behaves the same with // %> and # %>. However, the </script> tag doesn't break out of PHP mode in a one-line comment. /* style comments end at the first */ encountered. Make sure you don't nest /* style comments. It is easy to make this mistake if you are trying to comment out a large block of code.",
		more: "",
		link: "php.net/manual/en/language.basic-syntax.comments.php"
	},
	20: {
		syntax: ".=",
		target: "T_CONCAT_EQUAL",
		weight: parseTokenWeight,
		define: "<pre>$a .= $b</pre> : Same logic as <pre>$a = $a . $b</pre>",
		more: "This is referred to as a concatenating assignment operator ('.='), which appends the argument on the right side to the argument on the left side",
		link: "php.net/manual/en/language.operators.string.php"
	},
	21: {
		syntax: "const",
		target: "T_CONST",
		weight: parseTokenWeight,
		define: "A constant is an identifier (name) for a simple value. As the name suggests, that value cannot change during the execution of the script. A constant is case-sensitive by default. By convention, constant identifiers are always uppercase.",
		more: "The name of a constant follows the same rules as any label in PHP. A valid constant name starts with a letter or underscore, followed by any number of letters, numbers, or underscores.",
		link: "php.net/manual/en/language.constants.php"
	},
	22: {
		syntax: "\"foo\" or \'bar\'	",
		target: "T_CONSTANT_ENCAPSED_STRING",
		weight: parseTokenWeight,
		define: "A string literal can be specified in four different ways:single quoted, double quoted, heredoc syntax, nowdoc syntax",
		more: "<ul><li>Single Quote: The simplest way to specify a string is to enclose it in single quotes (the character '). To specify a literal single quote, escape it with a backslash (\). To specify a literal backslash, double it (\\). All other instances of backslash will be treated as a literal backslash: this means that the other escape sequences you might be used to, such as \r or \n, will be output literally as specified rather than having any special meaning</li><li>Double Quote: If the string is enclosed in double-quotes (\"), PHP will interpret escape sequences for special characters.</li><li>Heredoc: heredoc syntax: <<<. After this operator, an identifier is provided, then a newline. The string itself follows, and then the same identifier again to close the quotation.The closing identifier must begin in the first column of the line. Also, the identifier must follow the same naming rules as any other label in PHP: it must contain only alphanumeric characters and underscores, and must start with a non-digit character or underscore.</li><li>Nowdoc: Nowdocs are to single-quoted strings what heredocs are to double-quoted strings. A nowdoc is specified similarly to a heredoc, but no parsing is done inside a nowdoc. The construct is ideal for embedding PHP code or other large blocks of text without the need for escaping. It shares some features in common with the SGML <![CDATA[ ]]> construct, in that it declares a block of text which is not for parsing.A nowdoc is identified with the same <<< sequence used for heredocs, but the identifier which follows is enclosed in single quotes, e.g. <<<'EOT'. All the rules for heredoc identifiers also apply to nowdoc identifiers, especially those regarding the appearance of the closing identifier.</li></ul>",
		link: "php.net/manual/en/language.types.string.php#language.types.string.syntax"
	},
	23: {
		syntax: "continue",
		target: "T_CONTINUE",
		weight: parseTokenWeight,
		define: "continue is used within looping structures to skip the rest of the current loop iteration and continue execution at the condition evaluation and then the beginning of the next iteration.",
		more: "continue accepts an optional numeric argument which tells it how many levels of enclosing loops it should skip to the end of. The default value is 1, thus skipping to the end of the current loop.",
		link: "php.net/manual/en/control-structures.continue.php"
	},
	24: {
		syntax: "{$",
		target: "T_CURLY_OPEN",
		weight: parseTokenWeight,
		define: "This isn't called complex because the syntax is complex, but because it allows for the use of complex expressions.Any scalar variable, array element or object property with a string representation can be included via this syntax. Simply write the expression the same way as it would appear outside the string, and then wrap it in { and }. Since { can not be escaped, this syntax will only be recognised when the $ immediately follows the {. Use {\\$ to get a literal {$. Some examples to make it clear:",
		more: "",
		link: "php.net/manual/en/language.types.string.php#language.types.string.parsing.complex"
	},
	25: {
		syntax: "--",
		target: "T_DEC",
		weight: parseTokenWeight,
		define: "--$a: Pre-decrement decrements $a by one, then returns $a. $a--: Post-decrement returns $a, then decrements $a by one.",
		more: "The increment/decrement operators only affect numbers and strings. Arrays, objects and resources are not affected. Decrementing NULL values has no effect too, but incrementing them results in 1.",
		link: "php.net/manual/en/language.operators.increment.php"
	},
	26: {
		syntax: "declare",
		target: "T_DECLARE",
		weight: parseTokenWeight,
		define: "The declare construct is used to set execution directives for a block of code. The syntax of declare is similar to the syntax of other flow control constructs",
		more: "declare (directive). The directive section allows the behavior of the declare block to be set. Currently only three directives are recognized: the ticks directive, the encoding directive, and the strict_types directive.",
		link: "php.net/manual/en/control-structures.declare.php"
	},
	27: {
		syntax: "default",
		target: "T_DEFAULT",
		weight: parseTokenWeight,
		define: "The switch statement is similar to a series of IF statements on the same expression. In many occasions, you may want to compare the same variable (or expression) with many different values, and execute a different piece of code depending on which value it equals to. This is exactly what the switch statement is for. A special case is the default case. This case matches anything that wasn't matched by the other cases.",
		more: "",
		link: "php.net/manual/en/control-structures.switch.php"
	},
	28: {
		syntax: "__DIR__",
		target: "T_DIR",
		weight: parseTokenWeight,
		define: "The directory of the file. If used inside an include, the directory of the included file is returned. This is equivalent to dirname(__FILE__). This directory name does not have a trailing slash unless it is the root directory.",
		more: "PHP provides a large number of predefined constants to any script which it runs. Many of these constants, however, are created by various extensions, and will only be present when those extensions are available, either via dynamic loading or because they have been compiled in",
		link: "php.net/manual/en/language.constants.predefined.php"
	},
	29: {
		syntax: "/=",
		target: "T_DIV_EQUAL",
		weight: parseTokenWeight,
		define: "<pre>$a /= $b</pre>: Same logic as <pre>$a = $a / $b</pre>",
		more: "The division operator ("/") returns a float value unless the two operands are integers (or strings that get converted to integers) and the numbers are evenly divisible, in which case an integer value will be returned.",
		link: "http://www.php.net/manual/en/language.operators.arithmetic.php",
		link2: "php.net/manual/en/language.operators.assignment.php"
	},
	30: {
		syntax: "0.12, etc.",
		target: "T_DNUMBER",
		weight: parseTokenWeight,
		define: "Floating point numbers (also known as \"floats\", \"doubles\", or \"real numbers\")",
		more: "These can be specified using any of the following syntaxes: <pre>$a = 1.234;</pre><pre>$b = 1.2e3;</pre><pre>$c = 7E-10</pre>. The size of a float is platform-dependent, although a maximum of approximately 1.8e308 with a precision of roughly 14 decimal digits is a common value (the 64 bit IEEE format).",
		link: "php.net/manual/en/language.types.float.php"
	},
	31: {
		syntax: "/** */",
		target: "T_DOC_COMMENT",
		weight: parseTokenWeight,
		define: "/** style comments end at the first */ encountered. Make sure you don't nest /** style comments. It is easy to make this mistake if you are trying to comment out a large block of code.",
		more: "",
		link: "php.net/manual/en/language.basic-syntax.comments.php"
	},
	32: {
		syntax: "do",
		target: "T_DO",
		weight: parseTokenWeight,
		define: "do-while loops are very similar to while loops, except the truth expression is checked at the end of each iteration instead of in the beginning. The main difference from regular while loops is that the first iteration of a do-while loop is guaranteed to run (the truth expression is only checked at the end of the iteration), whereas it may not necessarily run with a regular while loop (the truth expression is checked at the beginning of each iteration, if it evaluates to FALSE right from the beginning, the loop execution would end immediately).",
		more: "",
		link: "php.net/manual/en/control-structures.do.while.php"
	},
	33: {
		syntax: "${",
		target: "T_DOLLAR_OPEN_CURLY_BRACES",
		weight: parseTokenWeight,
		define: "This isn't called complex because the syntax is complex, but because it allows for the use of complex expressions.Any scalar variable, array element or object property with a string representation can be included via this syntax. Simply write the expression the same way as it would appear outside the string, and then wrap it in { and }. Since { can not be escaped, this syntax will only be recognised when the $ immediately follows the {. Use {\\$ to get a literal {$. Some examples to make it clear:",
		more: "",
		link: "php.net/manual/en/language.types.string.php#language.types.string.parsing.complex"
	},
	34: {
		syntax: "=>",
		target: "T_DOUBLE_ARROW",
		weight: parseTokenWeight,
		define: "An array can be created using the array() language construct. It takes any number of comma-separated key => value pairs as arguments.",
		more: "",
		link: "php.net/manual/en/language.types.array.php#language.types.array.syntax"
	},
	35: {
		syntax: "(real),(double) or (float)",
		target: "T_DOUBLE_CAST",
		weight: parseTokenWeight,
		define: "(float), (double), (real) - cast to float",
		more: "These can be specified using any of the following syntaxes: <pre>$a = 1.234;</pre><pre>$b = 1.2e3;</pre><pre>$c = 7E-10</pre>. The size of a float is platform-dependent, although a maximum of approximately 1.8e308 with a precision of roughly 14 decimal digits is a common value (the 64 bit IEEE format).",
		link: "php.net/manual/en/language.types.type-juggling.php#language.types.typecasting"
	},
	36: {
		syntax: "::",
		target: "T_DOUBLE_COLON",
		weight: parseTokenWeight,
		define: "The Scope Resolution Operator (also called Paamayim Nekudotayim) or in simpler terms, the double colon, is a token that allows access to static, constant, and overridden properties or methods of a class.",
		more: "When referencing these items from outside the class definition, use the name of the class. Three special keywords self, parent and static are used to access properties or methods from inside the class definition.",
		link: "php.net/manual/en/language.oop5.paamayim-nekudotayim.php"
	},
	37: {
		syntax: "echo",
		target: "T_ECHO",
		weight: parseTokenWeight,
		define: "Outputs all parameters. No additional newline is appended.echo is not actually a function (it is a language construct), so you are not required to use parentheses with it. echo (unlike some other language constructs) does not behave like a function, so it cannot always be used in the context of a function. Additionally, if you want to pass more than one parameter to echo, the parameters must not be enclosed within parentheses.echo also has a shortcut syntax, where you can immediately follow the opening tag with an equals sign. Prior to PHP 5.4.0, this short syntax only works with the short_open_tag configuration setting enabled.",
		more: "Another Definition: A sound or series of sounds caused by the reflection of sound waves from a surface back to the listener.",
		link: "php.net/manual/en/function.echo.php"
	},
	38: {
		syntax: "...",
		target: "T_ELLIPSIS",
		weight: parseTokenWeight,
		define: "In PHP 5.6 and later, argument lists may include the ... token to denote that the function accepts a variable number of arguments. The arguments will be passed into the given variable as an array.",
		more: "",
		link: "php.net/manual/en/functions.arguments.php#functions.variable-arg-list.new"
	},
	39: {
		syntax: "else",
		target: "T_ELSE",
		weight: parseTokenWeight,
		define: "Often you'd want to execute a statement if a certain condition is met, and a different statement if the condition is not met. This is what else is for. else extends an if statement to execute a statement in case the expression in the if statement evaluates to FALSE.",
		more: "",
		link: "php.net/manual/en/control-structures.else.php"
	},
	40: {
		syntax: "elseif",
		target: "T_ELSEIF",
		weight: parseTokenWeight,
		define: "elseif, as its name suggests, is a combination of if and else. Like else, it extends an if statement to execute a different statement in case the original if expression evaluates to FALSE. However, unlike else, it will execute that alternative expression only if the elseif conditional expression evaluates to TRUE.",
		more: "There may be several elseifs within the same if statement. The first elseif expression (if any) that evaluates to TRUE would be executed. In PHP, you can also write 'else if' (in two words) and the behavior would be identical to the one of 'elseif' (in a single word). The syntactic meaning is slightly different (if you're familiar with C, this is the same behavior) but the bottom line is that both would result in exactly the same behavior. The elseif statement is only executed if the preceding if expression and any preceding elseif expressions evaluated to FALSE, and the current elseif expression evaluated to TRUE.",
		link: "php.net/manual/en/control-structures.elseif.php"
	},
	41: {
		syntax: "empty",
		target: "T_EMPTY",
		weight: parseTokenWeight,
		define: "Determine whether a variable is considered to be empty. A variable is considered empty if it does not exist or if its value equals FALSE. empty() does not generate a warning if the variable does not exist.",
		more: "",
		link: "php.net/manual/en/function.empty.php"
	},
	42: {
		syntax: "\" $a\"",
		target: "T_ENCAPSED_AND_WHITESPACE",
		weight: parseTokenWeight,
		define: "If a dollar sign ($) is encountered, the parser will greedily take as many tokens as possible to form a valid variable name. Enclose the variable name in curly braces to explicitly specify the end of the name.",
		more: "",
		link: "php.net/manual/en/language.types.string.php#language.types.string.parsing"
	},
	43: {
		syntax: "enddeclare",
		target: "T_ENDDECLARE",
		weight: parseTokenWeight,
		define: "The declare construct is used to set execution directives for a block of code. enddeclare is used to end a declare statement. ",
		more: "",
		link: "http://php.net/manual/en/control-structures.alternative-syntax.php",
		link2: "http://php.net/manual/en/control-structures.declare.php"
	},
	44: {
		syntax: "endfor",
		target: "T_ENDFOR",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	45: {
		syntax: "endforeach",
		target: "T_ENDFOREACH",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	46: {
		syntax: "endif",
		target: "T_ENDIF",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	47: {
		syntax: "endswitch",
		target: "T_ENDSWITCH",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	48: {
		syntax: "endwhile",
		target: "T_ENDWHILE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	49: {
		syntax: "",
		target: "T_END_HEREDOC",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	50: {
		syntax: "eval()",
		target: "T_EVAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	51: {
		syntax: "exit or die",
		target: "T_EXIT",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	52: {
		syntax: "extends",
		target: "T_EXTENDS",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	53: {
		syntax: "__FILE__",
		target: "T_FILE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	54: {
		syntax: "final",
		target: "T_FINAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	55: {
		syntax: "finally",
		target: "T_FINALLY",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	56: {
		syntax: "for",
		target: "T_FOR",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	57: {
		syntax: "foreach",
		target: "T_FOREACH",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	58: {
		syntax: "function or cfunction",
		target: "T_FUNCTION",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	59: {
		syntax: "__FUNCTION__",
		target: "T_FUNC_C",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	60: {
		syntax: "global",
		target: "T_GLOBAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	61: {
		syntax: "goto",
		target: "T_GOTO",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	62: {
		syntax: "__halt_compiler()",
		target: "T_HALT_COMPILER",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	63: {
		syntax: "if",
		target: "T_IF",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	64: {
		syntax: "implements",
		target: "T_IMPLEMENTS",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	65: {
		syntax: "++",
		target: "T_INC",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	66: {
		syntax: "include()",
		target: "T_INCLUDE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	67: {
		syntax: "include_once()",
		target: "T_INCLUDE_ONCE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	68: {
		syntax: "",
		target: "T_INLINE_HTML",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	69: {
		syntax: "instanceof",
		target: "T_INSTANCEOF",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	70: {
		syntax: "insteadof",
		target: "T_INSTEADOF",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	71: {
		syntax: "(int) or (integer)",
		target: "T_INT_CAST",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	72: {
		syntax: "interface",
		target: "T_INTERFACE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	73: {
		syntax: "isset()",
		target: "T_ISSET",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	74: {
		syntax: "==",
		target: "T_IS_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	75: {
		syntax: ">=",
		target: "T_IS_GREATER_OR_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	76: {
		syntax: "===",
		target: "T_IS_IDENTICAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	77: {
		syntax: "!= ir <>",
		target: "T_IS_NOT_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	78: {
		syntax: "!==",
		target: "T_IS_NOT_IDENTICAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	79: {
		syntax: "<=",
		target: "T_IS_SMALLER_OR_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	80: {
		syntax: "<=>",
		target: "T_SPACESHIP",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	81: {
		syntax: "__LINE__",
		target: "T_LINE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	82: {
		syntax: "list()",
		target: "T_LIST",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	83: {
		syntax: "123, 012, 0x1ac, etc",
		target: "T_LNUMBER",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	84: {
		syntax: "and",
		target: "T_LOGICAL_AND",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	85: {
		syntax: "or",
		target: "T_LOGICAL_OR",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	86: {
		syntax: "xor",
		target: "T_LOGICAL_XOR",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	87: {
		syntax: "__METHOD__",
		target: "T_METHOD_C",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	88: {
		syntax: "-=",
		target: "T_MINUS_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	89: {
		syntax: "%=",
		target: "T_MOD_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	90: {
		syntax: "*=",
		target: "T_MUL_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	91: {
		syntax: "namespace",
		target: "T_NAMESPACE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	92: {
		syntax: "__NAMESPACE__",
		target: "T_NS_C",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	93: {
		syntax: "\\",
		target: "T_NS_SEPARATOR",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	94: {
		syntax: "new",
		target: "T_NEW",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	95: {
		syntax: "$a[0]",
		target: "T_NUM_STRING",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	96: {
		syntax: "(object)",
		target: "T_OBJECT_CAST",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	97: {
		syntax: "->",
		target: "T_OBJECT_OPERATOR",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	98: {
		syntax: "<?php, <? or <%",
		target: "T_OPEN_TAG",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	99: {
		syntax: "<?= or <%=",
		target: "T_OPEN_TAG_WITH_ECHO",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	100: {
		syntax: "|=",
		target: "T_OR_EQUAL	",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	101: {
		syntax: "::",
		target: "T_PAAMAYIM_NEKUDOTAYIM",
		weight: parseTokenWeight
		define: "The Scope Resolution Operator (also called Paamayim Nekudotayim) or in simpler terms, the double colon, is a token that allows access to static, constant, and overridden properties or methods of a class.",
		more: "When referencing these items from outside the class definition, use the name of the class. Three special keywords self, parent and static are used to access properties or methods from inside the class definition.",
		link: "http://php.net/manual/en/language.oop5.paamayim-nekudotayim.php"
	},
	102: {
		syntax: "+=",
		target: "T_PLUS_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	103: {
		syntax: "**",
		target: "T_POW",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	104: {
		syntax: "**=",
		target: "T_POW_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	105: {
		syntax: "print()",
		target: "T_PRINT",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	106: {
		syntax: "private",
		target: "T_PRIVATE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	107: {
		syntax: "public",
		target: "T_PUBLIC",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	108: {
		syntax: "protected",
		target: "T_PROTECTED",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	109: {
		syntax: "require()",
		target: "T_REQUIRE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	110: {
		syntax: "require_once()",
		target: "T_REQUIRE_ONCE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	111: {
		syntax: "return",
		target: "T_RETURN",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	112: {
		syntax: "<<",
		target: "T_SL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	113: {
		syntax: "<<=",
		target: "T_SL_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	114: {
		syntax: ">>",
		target: "T_SR",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	115: {
		syntax: ">>=",
		target: "T_SR_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	116: {
		syntax: "<<<",
		target: "T_START_HEREDOC",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	117: {
		syntax: "static",
		target: "T_STATIC",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	118: {
		syntax: "parent, self, etc",
		target: "T_STRING",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	119: {
		syntax: "(string)",
		target: "T_STRING_CAST",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	120: {
		syntax: "\"${a",
		target: "T_STRING_VARNAME",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	121: {
		syntax: "switch",
		target: "T_SWITCH",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	122: {
		syntax: "throw",
		target: "T_THROW",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	123: {
		syntax: "trait",
		target: "T_TRAIT",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	124: {
		syntax: "__TRAIT__",
		target: "T_TRAIT_C",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	125: {
		syntax: "try",
		target: "T_TRY",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	126: {
		syntax: "unset()",
		target: "T_UNSET",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	127: {
		syntax: "(unset)",
		target: "T_UNSET_CAST",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	128: {
		syntax: "use",
		target: "T_USE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	129: {
		syntax: "var",
		target: "T_VAR",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	130: {
		syntax: "$foo",
		target: "T_VARIABLE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	131: {
		syntax: "while",
		target: "T_WHILE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	132: {
		syntax: "\\t \\r\\n",
		target: "T_WHITESPACE",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	133: {
		syntax: "^=",
		target: "T_XOR_EQUAL",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	134: {
		syntax: "yield",
		target: "T_YIELD",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	},
	135: {
		syntax: "yield from",
		target: "T_YIELD_FROM",
		weight: parseTokenWeight,
		define: "",
		more: "",
		link: ""
	}
}