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
		link: "www.php.net/manual/en/language.operators.arithmetic.php",
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
		link: "php.net/manual/en/control-structures.alternative-syntax.php",
		link2: "php.net/manual/en/control-structures.declare.php"
	},
	44: {
		syntax: "endfor",
		target: "T_ENDFOR",
		weight: parseTokenWeight,
		define: "for loops are the most complex loops in PHP. endfor is used to end a statement of a for loop instead of a }. I.E. <pre>for (expr1; expr2; expr3): {{statement}} endfor;</pre>",
		more: "",
		link: "php.net/manual/en/control-structures.for.php"
	},
	45: {
		syntax: "endforeach",
		target: "T_ENDFOREACH",
		weight: parseTokenWeight,
		define: "The foreach construct provides an easy way to iterate over arrays. foreach works only on arrays and objects, and will issue an error when you try to use it on a variable with a different data type or an uninitialized variable. The endforeach is used at the end of a foreach statement instead of } I.E. <pre>foreach (array() as $value): {{statement}} endforeach;</pre> ",
		more: "",
		link: "php.net/manual/en/control-structures.foreach.php"
	},
	46: {
		syntax: "endif",
		target: "T_ENDIF",
		weight: parseTokenWeight,
		define: "The if construct is one of the most important features of many languages, PHP included. It allows for conditional execution of code fragments. endif is used at the end of a statement  instead of }.  I.E. <pre>if (expr): {{statement}} endif;</pre> ",
		more: "",
		link: "php.net/manual/en/control-structures.if.php"
	},
	47: {
		syntax: "endswitch",
		target: "T_ENDSWITCH",
		weight: parseTokenWeight,
		define: "The switch statement is similar to a series of IF statements on the same expression. In many occasions, you may want to compare the same variable (or expression) with many different values, and execute a different piece of code depending on which value it equals to. endswitch is used at the end of a statement instead of }.  I.E. <pre>switch (expr): {{case ... statment}} endswitch;</pre> ",
		more: "",
		link: ""
	},
	48: {
		syntax: "endwhile",
		target: "T_ENDWHILE",
		weight: parseTokenWeight,
		define: "while loops are the simplest type of loop in PHP. The meaning of a while statement is simple. It tells PHP to execute the nested statement(s) repeatedly, as long as the while expression evaluates to TRUE.  endwhite is used at the end of a statement  instead of }. I.E. <pre>while (expr): {{statement}} endwhile;</pre> ",
		more: "",
		link: "php.net/manual/en/control-structures.while.php"
	},
	49: {
		syntax: "",
		target: "T_END_HEREDOC",
		weight: parseTokenWeight,
		define: "Closing of a heredoc. The closing identifier must begin in the first column of the line. Also, the identifier must follow the same naming rules as any other label in PHP: it must contain only alphanumeric characters and underscores, and must start with a non-digit character or underscore",
		more: "",
		link: "php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc"
	},
	50: {
		syntax: "eval()",
		target: "T_EVAL",
		weight: parseTokenWeight,
		define: "Evaluate a string as PHP code",
		more: "The eval() language construct is very dangerous because it allows execution of arbitrary PHP code. Its use thus is discouraged. If you have carefully verified that there is no other option than to use this construct, pay special attention not to pass any user provided data into it without properly validating it beforehand.",
		link: "php.net/manual/en/function.eval.php"
	},
	51: {
		syntax: "exit, die",
		target: "T_EXIT",
		weight: parseTokenWeight,
		define: "Output a message and terminate the current script",
		more: "Terminates execution of the script. Shutdown functions and object destructors will always be executed even if exit is called.exit is a language construct and it can be called without parentheses if no status is passed. f status is a string, this function prints the status just before exiting.If status is an integer, that value will be used as the exit status and not printed",
		link: "php.net/manual/en/function.exit.php"
	},
	52: {
		syntax: "extends",
		target: "T_EXTENDS",
		weight: parseTokenWeight,
		define: "A class can inherit the methods and properties of another class by using the keyword extends in the class declaration. It is not possible to extend multiple classes; a class can only inherit from one base class.",
		more: "The inherited methods and properties can be overridden by redeclaring them with the same name defined in the parent class. However, if the parent class has defined a method as final, that method may not be overridden. It is possible to access the overridden methods or static properties by referencing them with parent::.When overriding methods, the parameter signature should remain the same or PHP will generate an E_STRICT level error. This does not apply to the constructor, which allows overriding with different parameters.",
		link: "php.net/manual/en/language.oop5.basic.php#language.oop5.basic.extends"
	},
	53: {
		syntax: "__FILE__",
		target: "T_FILE",
		weight: parseTokenWeight,
		define: "The full path and filename of the file with symlinks resolved. If used inside an include, the name of the included file is returned.",
		more: "PHP provides a large number of predefined constants to any script which it runs. Many of these constants, however, are created by various extensions, and will only be present when those extensions are available, either via dynamic loading or because they have been compiled in.",
		link: "php.net/manual/en/language.constants.predefined.php"
	},
	54: {
		syntax: "final",
		target: "T_FINAL",
		weight: parseTokenWeight,
		define: "PHP 5 introduces the final keyword, which prevents child classes from overriding a method by prefixing the definition with final. If the class itself is being defined final then it cannot be extended.",
		more: "",
		link: "php.net/manual/en/language.oop5.final.php"
	},
	55: {
		syntax: "finally",
		target: "T_FINALLY",
		weight: parseTokenWeight,
		define: "n PHP 5.5 and later, a finally block may also be specified after or instead of catch blocks. Code within the finally block will always be executed after the try and catch blocks, regardless of whether an exception has been thrown, and before normal execution resumes.",
		more: "PHP has an exception model similar to that of other programming languages. An exception can be thrown, and caught (\"catched\") within PHP. Code may be surrounded in a try block, to facilitate the catching of potential exceptions. Each try must have at least one corresponding catch or finally block.",
		link: "php.net/manual/en/language.exceptions.php"
	},
	56: {
		syntax: "for",
		target: "T_FOR",
		weight: parseTokenWeight,
		define: "for loops are the most complex loops in PHP. They behave like their C counterparts. I.E. <pre>for (expr1; expr2; expr3) { statement } </pre>",
		more: "",
		link: "php.net/manual/en/control-structures.for.php"
	},
	57: {
		syntax: "foreach",
		target: "T_FOREACH",
		weight: parseTokenWeight,
		define: "The foreach construct provides an easy way to iterate over arrays. foreach works only on arrays and objects, and will issue an error when you try to use it on a variable with a different data type or an uninitialized variable.",
		more: "",
		link: "php.net/manual/en/control-structures.foreach.php"
	},
	58: {
		syntax: "function or cfunction",
		target: "T_FUNCTION",
		weight: parseTokenWeight,
		define: "A function may be defined by <pre> function {{name}}($arg1...) { code } </pre>. Any valid PHP code may appear inside a function, even other functions and class definitions.Function names follow the same rules as other labels in PHP. A valid function name starts with a letter or underscore, followed by any number of letters, numbers, or underscores. As a regular expression, it would be expressed thus: [a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*.",
		more: "Functions need not be defined before they are referenced, except when a function is conditionally defined. When a function is defined in a conditional manner, its definition must be processed prior to being called. ",
		link: "php.net/manual/en/language.functions.php"
	},
	59: {
		syntax: "__FUNCTION__",
		target: "T_FUNC_C",
		weight: parseTokenWeight,
		define: "The function name, or {closure} for anonymous functions.",
		more: "PHP provides a large number of predefined constants to any script which it runs. Many of these constants, however, are created by various extensions, and will only be present when those extensions are available, either via dynamic loading or because they have been compiled in.",
		link: "php.net/manual/en/language.constants.predefined.php"
	},
	60: {
		syntax: "global",
		target: "T_GLOBAL",
		weight: parseTokenWeight,
		define: "The scope of a variable is the context within which it is defined. For the most part all PHP variables only have a single scope. This single scope spans included and required files as well.",
		more: "global variables in C are automatically available to functions unless specifically overridden by a local definition. This can cause some problems in that people may inadvertently change a global variable. In PHP global variables must be declared global inside a function if they are going to be used in that function.",
		link: "php.net/manual/en/language.variables.scope.php"
	},
	61: {
		syntax: "goto",
		target: "T_GOTO",
		weight: parseTokenWeight,
		define: "The goto operator can be used to jump to another section in the program. The target point is specified by a label followed by a colon, and the instruction is given as goto followed by the desired target label. This is not a full unrestricted goto. The target label must be within the same file and context, meaning that you cannot jump out of a function or method, nor can you jump into one. You also cannot jump into any sort of loop or switch structure. You may jump out of these, and a common use is to use a goto in place of a multi-level break.",
		more: "",
		link: "php.net/manual/en/control-structures.goto.php"
	},
	62: {
		syntax: "__halt_compiler()",
		target: "T_HALT_COMPILER",
		weight: parseTokenWeight,
		define: "Halts the execution of the compiler. This can be useful to embed data in PHP scripts, like the installation files.",
		more: "",
		link: "php.net/manual/en/function.halt-compiler.php"
	},
	63: {
		syntax: "if",
		target: "T_IF",
		weight: parseTokenWeight,
		define: "The if construct is one of the most important features of many languages, PHP included. It allows for conditional execution of code fragments. ",
		more: "The expression is evaluated to its Boolean value. If expression evaluates to TRUE, PHP will execute statement, and if it evaluates to FALSE - it'll ignore it. ",
		link: "php.net/manual/en/control-structures.if.php"
	},
	64: {
		syntax: "implements",
		target: "T_IMPLEMENTS",
		weight: parseTokenWeight,
		define: "To implement an interface, the implements operator is used. All methods in the interface must be implemented within a class; failure to do so will result in a fatal error. Classes may implement more than one interface if desired by separating each interface with a comma.",
		more: "",
		link: "php.net/manual/en/language.oop5.interfaces.php"
	},
	65: {
		syntax: "++",
		target: "T_INC",
		weight: parseTokenWeight,
		define: "++$a (Pre-increment): Increments $a by one, then returns $a. $a++ (Post-increment): Returns $a, then increments $a by one.",
		more: "",
		link: "php.net/manual/en/language.operators.increment.php"
	},
	66: {
		syntax: "include()",
		target: "T_INCLUDE",
		weight: parseTokenWeight,
		define: "The include statement includes and evaluates the specified file.",
		more: "Files are included based on the file path given or, if none is given, the include_path specified. If the file isn't found in the include_path, include will finally check in the calling script's own directory and the current working directory before failing. The include construct will emit a warning if it cannot find a file.",
		link: "php.net/manual/en/function.include.php"
	},
	67: {
		syntax: "include_once()",
		target: "T_INCLUDE_ONCE",
		weight: parseTokenWeight,
		define: "The include_once statement includes and evaluates the specified file during the execution of the script. This is a behavior similar to the include statement, with the only difference being that if the code from a file has already been included, it will not be included again, and include_once returns TRUE. As the name suggests, the file will be included just once.",
		more: "include_once may be used in cases where the same file might be included and evaluated more than once during a particular execution of a script, so in this case it may help avoid problems such as function redefinitions, variable value reassignments, etc.",
		link: "php.net/manual/en/function.include-once.php"
	},
	68: {
		syntax: "",
		target: "T_INLINE_HTML",
		weight: parseTokenWeight,
		define: "Everything outside of a pair of opening and closing tags is ignored by the PHP parser which allows PHP files to have mixed content. This allows PHP to be embedded in HTML documents, for example to create templates.",
		more: "This works as expected, because when the PHP interpreter hits the ?> closing tags, it simply starts outputting whatever it finds until it hits another opening tag unless in the middle of a conditional statement in which case the interpreter will determine the outcome of the conditional before making a decision of what to skip over",
		link: "php.net/manual/en/language.basic-syntax.phpmode.php"
	},
	69: {
		syntax: "instanceof",
		target: "T_INSTANCEOF",
		weight: parseTokenWeight,
		define: "instanceof is used to determine whether a PHP variable is an instantiated object of a certain class.",
		more: "instanceof can also be used to determine whether a variable is an instantiated object of a class that inherits from a parent class",
		link: "php.net/manual/en/language.operators.type.php"
	},
	70: {
		syntax: "insteadof",
		target: "T_INSTEADOF",
		weight: parseTokenWeight,
		define: "If two Traits insert a method with the same name, a fatal error is produced, if the conflict is not explicitly resolved.To resolve naming conflicts between Traits used in the same class, the insteadof operator needs to be used to choose exactly one of the conflicting methods.Since this only allows one to exclude methods, the as operator can be used to add an alias to one of the methods. Note the as operator does not rename the method and it does not affect any other method either.",
		more: "",
		link: "php.net/manual/en/language.oop5.traits.php"
	},
	71: {
		syntax: "(int), (integer)",
		target: "T_INT_CAST",
		weight: parseTokenWeight,
		define: "Type casting in PHP works much as it does in C: the name of the desired type is written in parentheses before the variable which is to be cast.. (int), (integer) will cast to integer. ",
		more: "Integers can be specified in decimal (base 10), hexadecimal (base 16), octal (base 8) or binary (base 2) notation. The negation operator can be used to denote a negative integer.",
		link: "php.net/manual/en/language.types.type-juggling.php#language.types.typecasting"
	},
	72: {
		syntax: "interface",
		target: "T_INTERFACE",
		weight: parseTokenWeight,
		define: "Object interfaces allow you to create code which specifies which methods a class must implement, without having to define how these methods are implemented.",
		more: "Interfaces are defined in the same way as a class, but with the interface keyword replacing the class keyword and without any of the methods having their contents defined.All methods declared in an interface must be public; this is the nature of an interface.",
		link: "php.net/manual/en/language.oop5.interfaces.php"
	},
	73: {
		syntax: "isset()",
		target: "T_ISSET",
		weight: parseTokenWeight,
		define: "Determine if a variable is set and is not NULL",
		more: "If a variable has been unset with unset(), it will no longer be set. isset() will return FALSE if testing a variable that has been set to NULL. Also note that a null character (\"\\0\") is not equivalent to the PHP NULL constant.If multiple parameters are supplied then isset() will return TRUE only if all of the parameters are set. Evaluation goes from left to right and stops as soon as an unset variable is encountered.",
		link: "php.net/manual/en/function.isset.php"
	},
	74: {
		syntax: "==",
		target: "T_IS_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a == $b </pre> TRUE if $a is equal to $b after type juggling.",
		more: "If you compare a number with a string or the comparison involves numerical strings, then each string is converted to a number and the comparison performed numerically. These rules also apply to the switch statement. The type conversion does not take place when the comparison is === or !== as this involves comparing the type as well as the value.",
		link: "php.net/manual/en/language.operators.comparison.php"
	},
	75: {
		syntax: ">=",
		target: "T_IS_GREATER_OR_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a >= $b </pre>TRUE if $a is greater than or equal to $b.",
		more: "",
		link: "php.net/manual/en/language.operators.comparison.php"
	},
	76: {
		syntax: "===",
		target: "T_IS_IDENTICAL",
		weight: parseTokenWeight,
		define: "<pre> $a === $b </pre> TRUE if $a is equal to $b, and they are of the same type.",
		more: "If you compare a number with a string or the comparison involves numerical strings, then each string is converted to a number and the comparison performed numerically. These rules also apply to the switch statement. The type conversion does not take place when the comparison is === or !== as this involves comparing the type as well as the value.",
		link: "php.net/manual/en/language.operators.comparison.php"
	},
	77: {
		syntax: "!=, <>",
		target: "T_IS_NOT_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a != $b </pre> OR <pre> $a <> $b </pre> TRUE if $a is not equal to $b after type juggling.",
		more: "If you compare a number with a string or the comparison involves numerical strings, then each string is converted to a number and the comparison performed numerically. These rules also apply to the switch statement. The type conversion does not take place when the comparison is === or !== as this involves comparing the type as well as the value.",
		link: "php.net/manual/en/language.operators.comparison.php"
	},
	78: {
		syntax: "!==",
		target: "T_IS_NOT_IDENTICAL",
		weight: parseTokenWeight,
		define: "<pre> $a !== $b </pre> TRUE if $a is not equal to $b, or they are not of the same type.",
		more: "If you compare a number with a string or the comparison involves numerical strings, then each string is converted to a number and the comparison performed numerically. These rules also apply to the switch statement. The type conversion does not take place when the comparison is === or !== as this involves comparing the type as well as the value.",
		link: "php.net/manual/en/language.operators.comparison.php"
	},
	79: {
		syntax: "<=",
		target: "T_IS_SMALLER_OR_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a <= $b </pre> TRUE if $a is less than or equal to $b.",
		more: "",
		link: "php.net/manual/en/language.operators.comparison.php"
	},
	80: {
		syntax: "<=>",
		target: "T_SPACESHIP",
		weight: parseTokenWeight,
		define: "<pre> $a <=> $b </pre> An integer less than, equal to, or greater than zero when $a is respectively less than, equal to, or greater than $b. Available as of PHP 7.",
		more: "",
		link: "php.net/manual/en/language.operators.comparison.php"
	},
	81: {
		syntax: "__LINE__",
		target: "T_LINE",
		weight: parseTokenWeight,
		define: "The current line number of the file.",
		more: "PHP provides a large number of predefined constants to any script which it runs. Many of these constants, however, are created by various extensions, and will only be present when those extensions are available, either via dynamic loading or because they have been compiled in.",
		link: "php.net/manual/en/language.constants.predefined.php"
	},
	82: {
		syntax: "list()",
		target: "T_LIST",
		weight: parseTokenWeight,
		define: "Like array(), this is not really a function, but a language construct. list() is used to assign a list of variables in one operation.",
		more: "",
		link: "php.net/manual/en/function.list.php"
	},
	83: {
		syntax: "123, 012, 0x1ac, etc",
		target: "T_LNUMBER",
		weight: parseTokenWeight,
		define: "Integers can be specified in decimal (base 10), hexadecimal (base 16), octal (base 8) or binary (base 2) notation. The negation operator can be used to denote a negative integer.",
		more: "",
		link: "php.net/manual/en/language.types.integer.php"
	},
	84: {
		syntax: "and",
		target: "T_LOGICAL_AND",
		weight: parseTokenWeight,
		define: "<pre> $a and $b </pre> (And): TRUE if both $a and $b are TRUE.",
		more: "",
		link: "php.net/manual/en/language.operators.logical.php"
	},
	85: {
		syntax: "or",
		target: "T_LOGICAL_OR",
		weight: parseTokenWeight,
		define: "<pre> $a or $b </pre> (Or): TRUE if either $a or $b is TRUE.",
		more: "",
		link: "php.net/manual/en/language.operators.logical.php"
	},
	86: {
		syntax: "xor",
		target: "T_LOGICAL_XOR",
		weight: parseTokenWeight,
		define: "<pre> $a xor $b </pre> (Xor): TRUE if either $a or $b is TRUE, but not both.",
		more: "",
		link: "php.net/manual/en/language.operators.logical.php"
	},
	87: {
		syntax: "__METHOD__",
		target: "T_METHOD_C",
		weight: parseTokenWeight,
		define: "The class method name.",
		more: "PHP provides a large number of predefined constants to any script which it runs. Many of these constants, however, are created by various extensions, and will only be present when those extensions are available, either via dynamic loading or because they have been compiled in.",
		link: "php.net/manual/en/language.constants.predefined.php"
	},
	88: {
		syntax: "-=",
		target: "T_MINUS_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a -= $b </pre> Same as <pre> $a = $a - $b </pre>",
		more: "",
		link: "php.net/manual/en/language.operators.assignment.php"
	},
	89: {
		syntax: "%=",
		target: "T_MOD_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a %= $b </pre> Same as <pre> $a = $a % $b </pre>",
		more: "",
		link: "php.net/manual/en/language.operators.assignment.php"
	},
	90: {
		syntax: "*=",
		target: "T_MUL_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a *= $b </pre> Same as <pre> $a = $a * $b </pre>",
		more: "",
		link: "php.net/manual/en/language.operators.assignment.php"
	},
	91: {
		syntax: "namespace",
		target: "T_NAMESPACE",
		weight: parseTokenWeight,
		define: "Namespaces are a way of encapsulating items. This can be seen as an abstract concept in many places. For example, in any operating system directories serve to group related files, and act as a namespace for the files within them. PHP Namespaces provide a way in which to group related classes, interfaces, functions and constants.",
		more: "As a concrete example, the file foo.txt can exist in both directory /home/greg and in /home/other, but two copies of foo.txt cannot co-exist in the same directory. In addition, to access the foo.txt file outside of the /home/greg directory, we must prepend the directory name to the file name using the directory separator to get /home/greg/foo.txt. This same principle extends to namespaces in the programming world.",
		link: "php.net/manual/en/language.namespaces.rationale.php"
	},
	92: {
		syntax: "__NAMESPACE__",
		target: "T_NS_C",
		weight: parseTokenWeight,
		define: "The name of the current namespace. PHP supports two ways of abstractly accessing elements within the current namespace, the __NAMESPACE__ magic constant, and the namespace keyword.",
		more: "The value of __NAMESPACE__ is a string that contains the current namespace name. In global, un-namespaced code, it contains an empty string.",
		link: "php.net/manual/en/language.constants.predefined.php",
		link2: "php.net/manual/en/language.namespaces.nsconstants.php"
	},
	93: {
		syntax: "\\",
		target: "T_NS_SEPARATOR",
		weight: parseTokenWeight,
		define: "Much like directories and files, PHP namespaces also contain the ability to specify a hierarchy of namespace names. Thus, a namespace name can be defined with sub-levels. I.E. <pre>namespace MyProject\\Sub\\Level;</pre>",
		more: "",
		link: "php.net/manual/en/language.namespaces.nested.php"
	},
	94: {
		syntax: "new",
		target: "T_NEW",
		weight: parseTokenWeight,
		define: "To create an instance of a class, the new keyword must be used. An object will always be created unless the object has a constructor defined that throws an exception on error. Classes should be defined before instantiation (and in some cases this is a requirement).If a string containing the name of a class is used with new, a new instance of that class will be created. If the class is in a namespace, its fully qualified name must be used when doing this.",
		more: "When assigning an already created instance of a class to a new variable, the new variable will access the same instance as the object that was assigned. This behaviour is the same when passing instances to a function. A copy of an already created object can be made by cloning it.",
		link: "php.net/manual/en/language.oop5.basic.php"
	},
	95: {
		syntax: "$a[0]",
		target: "T_NUM_STRING",
		weight: parseTokenWeight,
		define: "With array indices, the closing square bracket (]) marks the end of the index. The same rules apply to object properties as to simple variables.",
		more: "As of PHP 7.1.0 also negative numeric indices are supported.",
		link: "php.net/manual/en/language.types.string.php#language.types.string.parsing"
	},
	96: {
		syntax: "(object)",
		target: "T_OBJECT_CAST",
		weight: parseTokenWeight,
		define: "cast to object",
		more: "If an object is converted to an object, it is not modified. If a value of any other type is converted to an object, a new instance of the stdClass built-in class is created. If the value was NULL, the new instance will be empty. An array converts to an object with properties named by keys and corresponding values. Note that in this case before PHP 7.2.0 numeric keys have been inaccessible unless iterated.",
		link: "php.net/manual/en/language.types.type-juggling.php#language.types.typecasting",
		link2: "php.net/manual/en/language.types.object.php"
	},
	97: {
		syntax: "->",
		target: "T_OBJECT_OPERATOR",
		weight: parseTokenWeight,
		define: "Within class methods non-static properties may be accessed by using -> (Object Operator): <pre>$this->property</pre> (where property is the name of the property). Static properties are accessed by using the :: (Double Colon): <pre>self::$property</pre>",
		more: "",
		link: "php.net/manual/en/language.oop5.properties.php"
	},
	98: {
		syntax: "<?php, <? or <%",
		target: "T_OPEN_TAG",
		weight: parseTokenWeight,
		define: "In PHP 5, there are up to five different pairs of opening and closing tags available in PHP, depending on how PHP is configured. Two of these, <?php ?> and <script language=\"php\"> </script>, are always available. There is also the short echo tag <?= ?>, which is always available in PHP 5.4.0 and later.The other two are short tags and ASP style tags. As such, while some people find short tags and ASP style tags convenient, they are less portable, and generally not recommended.PHP 7 removes support for ASP tags and <script language=\"php\"> tags. As such, we recommend only using <?php ?> and <?= ?> when writing PHP code to maximise compatibility.",
		more: "",
		link: "php.net/manual/en/language.basic-syntax.phpmode.php"
	},
	99: {
		syntax: "<?= or <%=",
		target: "T_OPEN_TAG_WITH_ECHO",
		weight: parseTokenWeight,
		define: "Shorthand version of <pre><?php echo</pre>",
		more: "",
		link: "php.net/manual/en/language.basic-syntax.phpmode.php"
	},
	100: {
		syntax: "|=",
		target: "T_OR_EQUAL	",
		weight: parseTokenWeight,
		define: "<pre> $a |= $b </pre> Same as <pre> $a = $a | $b </pre>",
		more: "",
		link: "php.net/manual/en/language.operators.assignment.php"
	},
	101: {
		syntax: "::",
		target: "T_PAAMAYIM_NEKUDOTAYIM",
		weight: parseTokenWeight,
		define: "The Paamayim Nekudotayim (also called Scope Resolution Operator) or in simpler terms, the double colon, is a token that allows access to static, constant, and overridden properties or methods of a class.",
		more: "When referencing these items from outside the class definition, use the name of the class. Three special keywords self, parent and static are used to access properties or methods from inside the class definition.",
		link: "php.net/manual/en/language.oop5.paamayim-nekudotayim.php"
	},
	102: {
		syntax: "+=",
		target: "T_PLUS_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a += $b </pre> Same as <pre> $a = $a + $b </pre>",
		more: "",
		link: "php.net/manual/en/language.operators.assignment.php"
	},
	103: {
		syntax: "**",
		target: "T_POW",
		weight: parseTokenWeight,
		define: "<pre> $a ** $b </pre> (Exponentiation): Result of raising $a to the $b'th power. Introduced in PHP 5.6.",
		more: "",
		link: "php.net/manual/en/language.operators.arithmetic.php"
	},
	104: {
		syntax: "**=",
		target: "T_POW_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a **= $b </pre> Same as <pre> $a = $a ** $b </pre>",
		more: "",
		link: "php.net/manual/en/language.operators.arithmetic.php"
	},
	105: {
		syntax: "print()",
		target: "T_PRINT",
		weight: parseTokenWeight,
		define: "print is not actually a real function (it is a language construct) so you are not required to use parentheses with its argument list.The major differences to echo are that print only accepts a single argument and always returns 1.",
		more: "",
		link: "php.net/manual/en/function.print.php"
	},
	106: {
		syntax: "private",
		target: "T_PRIVATE",
		weight: parseTokenWeight,
		define: "The visibility of a property, a method or (as of PHP 7.1.0) a constant can be defined by prefixing the declaration with the keywords public, protected or private. Class members declared public can be accessed everywhere. Members declared protected can be accessed only within the class itself and by inheriting and parent classes. Members declared as private may only be accessed by the class that defines the member.",
		more: "",
		link: "php.net/manual/en/language.oop5.visibility.php"
	},
	107: {
		syntax: "public",
		target: "T_PUBLIC",
		weight: parseTokenWeight,
		define: "The visibility of a property, a method or (as of PHP 7.1.0) a constant can be defined by prefixing the declaration with the keywords public, protected or private. Class members declared public can be accessed everywhere. Members declared protected can be accessed only within the class itself and by inheriting and parent classes. Members declared as private may only be accessed by the class that defines the member.",
		more: "",
		link: "php.net/manual/en/language.oop5.visibility.php"
	},
	108: {
		syntax: "protected",
		target: "T_PROTECTED",
		weight: parseTokenWeight,
		define: "The visibility of a property, a method or (as of PHP 7.1.0) a constant can be defined by prefixing the declaration with the keywords public, protected or private. Class members declared public can be accessed everywhere. Members declared protected can be accessed only within the class itself and by inheriting and parent classes. Members declared as private may only be accessed by the class that defines the member.",
		more: "",
		link: "php.net/manual/en/language.oop5.visibility.php"
	},
	109: {
		syntax: "require()",
		target: "T_REQUIRE",
		weight: parseTokenWeight,
		define: "require is identical to include except upon failure it will also produce a fatal E_COMPILE_ERROR level error. In other words, it will halt the script whereas include only emits a warning (E_WARNING) which allows the script to continue.",
		more: "",
		link: "php.net/manual/en/function.require.php"
	},
	110: {
		syntax: "require_once()",
		target: "T_REQUIRE_ONCE",
		weight: parseTokenWeight,
		define: "The require_once statement is identical to require except PHP will check if the file has already been included, and if so, not include (require) it again.",
		more: "",
		link: "php.net/manual/en/function.require-once.php"
	},
	111: {
		syntax: "return",
		target: "T_RETURN",
		weight: parseTokenWeight,
		define: "Values are returned by using the optional return statement. Any type may be returned, including arrays and objects. This causes the function to end its execution immediately and pass control back to the line from which it was called",
		more: "If called from within a function, the return statement immediately ends execution of the current function, and returns its argument as the value of the function call. return also ends the execution of an eval() statement or script file.If called from the global scope, then execution of the current script file is ended. If the current script file was included or required, then control is passed back to the calling file. Furthermore, if the current script file was included, then the value given to return will be returned as the value of the include call. If return is called from within the main script file, then script execution ends. If the current script file was named by the auto_prepend_file or auto_append_file configuration options in php.ini, then that script file's execution is ended.",
		link: "php.net/manual/en/functions.returning-values.php",
		link2: "php.net/manual/en/function.return.php"
	},
	112: {
		syntax: "<<",
		target: "T_SL",
		weight: parseTokenWeight,
		define: "<pre> $a << $b </pre> (Shift left): Shift the bits of $a $b steps to the left (each step means \"multiply by two\")",
		more: "",
		link: "php.net/manual/en/language.operators.bitwise.php"
	},
	113: {
		syntax: "<<=",
		target: "T_SL_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a <<= $b </pre> Same as <pre> $a = $a << $b </pre>",
		more: "",
		link: "php.net/manual/en/language.operators.assignment.php"
	},
	114: {
		syntax: ">>",
		target: "T_SR",
		weight: parseTokenWeight,
		define: "<pre> $a >> $b </pre> (Shift right): hift the bits of $a $b steps to the right (each step means \"divide by two\")",
		more: "",
		link: "php.net/manual/en/language.operators.bitwise.php"
	},
	115: {
		syntax: ">>=",
		target: "T_SR_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a >>= $b </pre> Same as <pre> $a = $a >> $b </pre>",
		more: "",
		link: "php.net/manual/en/language.operators.assignment.php"
	},
	116: {
		syntax: "<<<",
		target: "T_START_HEREDOC",
		weight: parseTokenWeight,
		define: "eredoc syntax: <<<. After this operator, an identifier is provided, then a newline. The string itself follows, and then the same identifier again to close the quotation.",
		more: "The closing identifier must begin in the first column of the line. Also, the identifier must follow the same naming rules as any other label in PHP: it must contain only alphanumeric characters and underscores, and must start with a non-digit character or underscore.",
		link: "php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc"
	},
	117: {
		syntax: "static",
		target: "T_STATIC",
		weight: parseTokenWeight,
		define: "A static variable exists only in a local function scope, but it does not lose its value when program execution leaves this scope.",
		more: "",
		link: "php.net/manual/en/language.variables.scope.php"
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
		define: "A value can be converted to a string using the (string) cast or the strval() function. String conversion is automatically done in the scope of an expression where a string is needed. This happens when using the echo or print functions, or when a variable is compared to a string. The sections on Types and Type Juggling will make the following clearer. See also the settype() function.",
		more: "A boolean TRUE value is converted to the string \"1\". Boolean FALSE is converted to \"\" (the empty string). This allows conversion back and forth between boolean and string values.An integer or float is converted to a string representing the number textually (including the exponent part for floats). Floating point numbers can be converted using exponential notation (4.1E+6). Arrays are always converted to the string \"Array\"; because of this, echo and print can not by themselves show the contents of an array. To view a single element, use a construction such as echo $arr['foo']. See below for tips on viewing the entire contents.In order to convert objects to string magic method __toString must be used.Resources are always converted to strings with the structure \"Resource id #1\", where 1 is the resource number assigned to the resource by PHP at runtime. While the exact structure of this string should not be relied on and is subject to change, it will always be unique for a given resource within the lifetime of a script being executed (ie a Web request or CLI process) and won't be reused. To get a resource's type, use the get_resource_type() function.NULL is always converted to an empty string.As stated above, directly converting an array, object, or resource to a string does not provide any useful information about the value beyond its type. See the functions print_r() and var_dump() for more effective means of inspecting the contents of these types.Most PHP values can also be converted to strings for permanent storage. This method is called serialization, and is performed by the serialize() function. If the PHP engine was built with WDDX support, PHP values can also be serialized as well-formed XML text.",
		link: "php.net/manual/en/language.types.type-juggling.php#language.types.typecasting",
		link2: "php.net/manual/en/language.types.string.php"
	},
	120: {
		syntax: "\"${a",
		target: "T_STRING_VARNAME",
		weight: parseTokenWeight,
		define: "This allows for the use of complex expressions.Any scalar variable, array element or object property with a string representation can be included via this syntax. Simply write the expression the same way as it would appear outside the string, and then wrap it in { and }. Since { can not be escaped, this syntax will only be recognised when the $ immediately follows the {. Use {\\$ to get a literal {$",
		more: "",
		link: "php.net/manual/en/language.types.string.php#language.types.string.parsing.complex"
	},
	121: {
		syntax: "switch",
		target: "T_SWITCH",
		weight: parseTokenWeight,
		define: "The switch statement is similar to a series of IF statements on the same expression. In many occasions, you may want to compare the same variable (or expression) with many different values, and execute a different piece of code depending on which value it equals to. This is exactly what the switch statement is for.",
		more: "",
		link: "php.net/manual/en/control-structures.switch.php"
	},
	122: {
		syntax: "throw",
		target: "T_THROW",
		weight: parseTokenWeight,
		define: "PHP has an exception model similar to that of other programming languages. An exception can be thrown, and caught (\"catched\") within PHP. Code may be surrounded in a try block, to facilitate the catching of potential exceptions. Each try must have at least one corresponding catch or finally block.The thrown object must be an instance of the Exception class or a subclass of Exception. Trying to throw an object that is not will result in a PHP Fatal Error.",
		more: "",
		link: "php.net/manual/en/language.exceptions.php"
	},
	123: {
		syntax: "trait",
		target: "T_TRAIT",
		weight: parseTokenWeight,
		define: "Traits are a mechanism for code reuse in single inheritance languages such as PHP. A Trait is intended to reduce some limitations of single inheritance by enabling a developer to reuse sets of methods freely in several independent classes living in different class hierarchies. The semantics of the combination of Traits and classes is defined in a way which reduces complexity, and avoids the typical problems associated with multiple inheritance and Mixins.",
		more: "A Trait is similar to a class, but only intended to group functionality in a fine-grained and consistent way. It is not possible to instantiate a Trait on its own. It is an addition to traditional inheritance and enables horizontal composition of behavior; that is, the application of class members without requiring inheritance",
		link: "php.net/manual/en/language.oop5.traits.php"
	},
	124: {
		syntax: "__TRAIT__",
		target: "T_TRAIT_C",
		weight: parseTokenWeight,
		define: "The trait name. The trait name includes the namespace it was declared in (e.g. Foo\\Bar).",
		more: "",
		link: "php.net/manual/en/language.constants.predefined.php",
		link2: "php.net/manual/en/language.oop5.traits.php"
	},
	125: {
		syntax: "try",
		target: "T_TRY",
		weight: parseTokenWeight,
		define: "PHP has an exception model similar to that of other programming languages. An exception can be thrown, and caught (\"catched\") within PHP. Code may be surrounded in a try block, to facilitate the catching of potential exceptions. Each try must have at least one corresponding catch or finally block.The thrown object must be an instance of the Exception class or a subclass of Exception. Trying to throw an object that is not will result in a PHP Fatal Error.",
		more: "",
		link: "php.net/manual/en/language.exceptions.php"
	},
	126: {
		syntax: "unset()",
		target: "T_UNSET",
		weight: parseTokenWeight,
		define: "The behavior of unset() inside of a function can vary depending on what type of variable you are attempting to destroy.If a globalized variable is unset() inside of a function, only the local variable is destroyed. The variable in the calling environment will retain the same value as before unset() was called.",
		more: "",
		link: "php.net/manual/en/function.unset.php"
	},
	127: {
		syntax: "(unset)",
		target: "T_UNSET_CAST",
		weight: parseTokenWeight,
		define: "Casting a variable to null using (unset) $var will not remove the variable or unset its value. It will only return a NULL value. The (unset) cast has been deprecated as of PHP 7.2.0. Note that the (unset) cast is the same as assigning the value NULL to the variable or call. The (unset) cast will be removed as of PHP 8.0.0.",
		more: "",
		link: "php.net/manual/en/language.types.type-juggling.php#language.types.typecasting"
	},
	128: {
		syntax: "use",
		target: "T_USE",
		weight: parseTokenWeight,
		define: "The ability to refer to an external fully qualified name with an alias, or importing, is an important feature of namespaces. This is similar to the ability of unix-based filesystems to create symbolic links to a file or to a directory.All versions of PHP that support namespaces support three kinds of aliasing or importing: aliasing a class name, aliasing an interface name, and aliasing a namespace name. PHP 5.6+ also allows aliasing or importing function and constant names.In PHP, aliasing is accomplished with the use operator",
		more: "",
		link: "php.net/manual/en/language.namespaces.importing.php"
	},
	129: {
		syntax: "var",
		target: "T_VAR",
		weight: parseTokenWeight,
		define: "Class member variables are called \"properties\". You may also see them referred to using other terms such as \"attributes\" or \"fields\", but for the purposes of this reference we will use \"properties\". They are defined by using one of the keywords public, protected, or private, followed by a normal variable declaration. This declaration may include an initialization, but this initialization must be a constant value--that is, it must be able to be evaluated at compile time and must not depend on run-time information in order to be evaluated.",
		more: "",
		link: "php.net/manual/en/language.oop5.properties.php"
	},
	130: {
		syntax: "$foo",
		target: "T_VARIABLE",
		weight: parseTokenWeight,
		define: "Variables in PHP are represented by a dollar sign followed by the name of the variable. The variable name is case-sensitive.Variable names follow the same rules as other labels in PHP. A valid variable name starts with a letter or underscore, followed by any number of letters, numbers, or underscores.",
		more: "",
		link: "php.net/manual/en/language.variables.basics.php"
	},
	131: {
		syntax: "while",
		target: "T_WHILE",
		weight: parseTokenWeight,
		define: "while loops are the simplest type of loop in PHP. They behave just like their C counterparts. The basic form of a while statement is: <pre> while (expr){  statement } </pre> The meaning of a while statement is simple. It tells PHP to execute the nested statement(s) repeatedly, as long as the while expression evaluates to TRUE. The value of the expression is checked each time at the beginning of the loop, so even if this value changes during the execution of the nested statement(s), execution will not stop until the end of the iteration (each time PHP runs the statements in the loop is one iteration). Sometimes, if the while expression evaluates to FALSE from the very beginning, the nested statement(s) won't even be run once.",
		more: "",
		link: "php.net/manual/en/control-structures.while.php"
	},
	132: {
		syntax: "\\t \\r\\n",
		target: "T_WHITESPACE",
		weight: parseTokenWeight,
		define: "<pre>\\r</pre> = \"return\", <pre>\\n</pre> = \"new line\" and <pre>\\t</pre> = \"tab\"",
		more: "",
		link: "stackoverflow.com/questions/15423001/how-are-r-t-and-n-different-from-one-another"
	},
	133: {
		syntax: "^=",
		target: "T_XOR_EQUAL",
		weight: parseTokenWeight,
		define: "<pre> $a ^= $b </pre> Same as: <pre> $a = $a ^ $b </pre>",
		more: "",
		link: "php.net/manual/en/language.operators.assignment.php"
	},
	134: {
		syntax: "yield",
		target: "T_YIELD",
		weight: parseTokenWeight,
		define: "The heart of a generator function is the yield keyword. In its simplest form, a yield statement looks much like a return statement, except that instead of stopping execution of the function and returning, yield instead provides a value to the code looping over the generator and pauses execution of the generator function.",
		more: "",
		link: "php.net/manual/en/language.generators.syntax.php#control-structures.yield"
	},
	135: {
		syntax: "yield from",
		target: "T_YIELD_FROM",
		weight: parseTokenWeight,
		define: "In PHP 7, generator delegation allows you to yield values from another generator, Traversable object, or array by using the yield from keyword. The outer generator will then yield all values from the inner generator, object, or array until that is no longer valid, after which execution will continue in the outer generator.If a generator is used with yield from, the yield from expression will also return any value returned by the inner generator.",
		more: "",
		link: "php.net/manual/en/language.generators.syntax.php#control-structures.yield.from"
	}
}


function formatPhpMessage(message, extraData)
{
	var message = message.split("PHP message:");
	var firstPartOfMessage = message[0];
	message.shift();
	if(typeof message !== "string")
	{
		message = message.join("PHP message:");
	}
	var restOfMessage = message.split(":");
	var messageWarning = restOfMessage[0];
	var severity = "";
	if(logFormatPhpShowImg === "true")
	{
		severity = "<img src=\""+getPhpSeverifyLevel(messageWarning)+"\" height=\"15px\">";
	}
	restOfMessage.shift();
	restOfMessage = restOfMessage.join(":");
	restOfMessage = parseErrorMessage(restOfMessage, extraData);
	if(firstPartOfMessage !== "")
	{
		firstPartOfMessage = formatMainMessage(firstPartOfMessage, extraData);
	}
	buttonOfInfo = "";
	if(logFormatShowMoreButton === "true")
	{
		let morePhpInfo = getMorePhpInfo(restOfMessage);
		let buttonOfInfo = "";
		if(Object.keys(morePhpInfo).length > 0)
		{
			buttonOfInfo = "<span><span style=\"float:right; margin-top: -3px;\" class=\"linkSmall\" onclick=\"showMoreInfo(this)\" >More Info</span><div style=\"display: none;\" >"+formatMoreInfo(morePhpInfo)+"</div></span>"
		}
	}
	return firstPartOfMessage+"<div>"+severity+messageWarning+buttonOfInfo+"</div><div class=\"settingsDiv\">"+restOfMessage+"</div>";
}

function getMorePhpInfo(message)
{
	let counterOfHits = 0;
	let returnInfoObj = {};
	let phpInfoArrKeys = Object.keys(phpInfoArr);
	let phpInfoArrKeysLength = phpInfoArrKeys.length;
	for(let PIAKCount = 0; PIAKCount < phpInfoArrKeysLength; PIAKCount++)
	{
		let search = "("+phpInfoArr[phpInfoArrKeys[PIAKCount]]["target"]+")";
		if(message.indexOf(search) > -1)
		{
			let link2Text = "";
			if("link2" in phpInfoArr[phpInfoArrKeys[PIAKCount]])
			{
				link2Text = phpInfoArr[phpInfoArrKeys[PIAKCount]]["link2"];
			}
			returnInfoObj[counterOfHits] = {
				"hit" : phpInfoArr[phpInfoArrKeys[PIAKCount]]["target"],
				"info": phpInfoArr[phpInfoArrKeys[PIAKCount]]["define"],
				"moreinfo": phpInfoArr[phpInfoArrKeys[PIAKCount]]["more"],
				"link" : phpInfoArr[phpInfoArrKeys[PIAKCount]]["link"],
				"link2" : link2Text,
				"syntax" : phpInfoArr[phpInfoArrKeys[PIAKCount]]["syntax"]
			}
			counterOfHits++;
		}
	}
	return returnInfoObj;
}

function parseErrorMessage(restOfMessage, extraData)
{
	//check for client and extra data after that
	//0: main data, 1: client, 2: server, 3: request, 4: upstream, 5: host, 6: referrer
	var arrayOfData = {
		0: {
			"string"	: restOfMessage,
			"key"		: "",
			"position"	: -1
		},
		1: {
			"string"	: "",
			"key"		: "Client:",
			"position"	: restOfMessage.indexOf(", client:")
		},
		2: {
			"string"	: "",
			"key"		: "Server:",
			"position"	: restOfMessage.indexOf(", server:")
		},
		3: {
			"string"	: "",
			"key"		: "Request:",
			"position"	: restOfMessage.indexOf(", request:")
		},
		4: {
			"string"	: "",
			"key"		: "Upstream:",
			"position"	: restOfMessage.indexOf(", upstream:")
		},
		5: {
			"string"	: "",
			"key"		: "Host:",
			"position"	: restOfMessage.indexOf(", host:")
		},
		6: {
			"string"	: "",
			"key"		: "Referrer:",
			"position"	: restOfMessage.indexOf(", referrer:")
		},
	};
	var arrayOfDataKeys = Object.keys(arrayOfData);
	var trimmedMainData = false;
	var atLeastOnePresent = false;
	var skipLogic = false;
	for(var aodc = 1; aodc < 7; aodc++)
	{
		if(!skipLogic)
		{
			//start filter, get lowest position (ext -1) then trim that out (first lowest to second lowest)
			var lowest = -1;
			var lowestPos = 0;
			for(var aodc2 = 1; aodc2 < 7; aodc2++)
			{
				if((arrayOfData[arrayOfDataKeys[aodc2]]["position"] < lowest || lowest === -1 ) && arrayOfData[arrayOfDataKeys[aodc2]]["position"] > -1)
				{
					atLeastOnePresent = true;
					lowest = arrayOfData[arrayOfDataKeys[aodc2]]["position"];
					lowestPos = aodc2;
				}
			}
			if(lowest !== -1)
			{
				//find second lowest, cut out that part anad add to array of data
				arrayOfData[arrayOfDataKeys[lowestPos]]["position"] = -1;
				var secondLowest = restOfMessage.length;
				for(var aodc3 = 1; aodc3 < 7; aodc3++)
				{
					if(arrayOfData[arrayOfDataKeys[aodc3]]["position"] < secondLowest && arrayOfData[arrayOfDataKeys[aodc3]]["position"] !== -1)
					{
						secondLowest = arrayOfData[arrayOfDataKeys[aodc3]]["position"];
					}
				}
				arrayOfData[arrayOfDataKeys[lowestPos]]["string"] = restOfMessage.substring(lowest + 1, secondLowest);
				if(!trimmedMainData)
				{
					arrayOfData[arrayOfDataKeys[0]]["string"] = restOfMessage.substring(0, lowest);
					trimmedMainData = true;
				}
			}
			else
			{
				skipLogic = true;
			}
		}
	}
	var newHtmlToSend = "";
	if(logFormatPhpHideExtra !== "false")
	{
		return "<div>"+formatMainMessage(arrayOfData[arrayOfDataKeys[0]]["string"].trim(), extraData)+"</div>";
	}
	for(var aodc4 = 0; aodc4 < 7; aodc4++)
	{
		if(arrayOfData[arrayOfDataKeys[aodc4]]["string"] !== "")
		{
			newHtmlToSend += "<div>"+formatMainMessage(arrayOfData[arrayOfDataKeys[aodc4]]["string"].trim(), extraData)+"</div>";
		}
	}
	return newHtmlToSend;
}

function getPhpSeverifyLevel(snippit)
{
	return getSeverifyLevel(snippit, phpRedWarningArr, phpYellowWarningArr);
}