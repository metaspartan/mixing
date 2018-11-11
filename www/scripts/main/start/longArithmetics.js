function long_addition(x, y) {
	var     	z = '',
		maxLength = Math.max(x.length-1, y.length-1),
	     	 temp = '';
	if (x.length > y.length) {
		y = '0'.repeat(x.length-y.length) + y;
	} else {
		x = '0'.repeat(y.length-x.length) + x;
	}
	var previous = 0;
	var S = 0;
	for (var i = maxLength; i >=0 ; i--) {
		S = x[i]*1 + y[i]*1;
		S += previous;
		temp = S%10;
		z = temp + z;
		previous = Math.floor(S/10);
		if (0 == i && previous>0) {
			z = previous + z;
		}
	}
	return z;
}

function long_subtraction(x,y) { // here x > y, i do not care about sign
	var z         = '',
		maxLength = Math.max(x.length-1, y.length-1),
		j         = 0,
		temp      = 0;
	y = '0'.repeat(x.length-y.length) + y;
	for (var i = maxLength; i >=0 ; i--) {
		if (x[i] >= y[i]) {
			z = (x[i]*1-y[i]*1).toString() + z;
		} else {
			z = (10+x[i]*1-y[i]*1).toString() + z;			
			j = i-1;			
			while (0 == x[j]) {
				x = x.substring(0,j) + "9" + x.substring(j+1);
				j--;
			}
			temp = 1*x[j] - 1;
			x = x.substring(0,j) + (temp.toString()) + x.substring(j+1);
		}
	}
	var i = firstGreaterThan(z, 1);
	z = z.substring(i);
	return z;
}

function long_multiplication(x,y) {
	var P = '0', S = '0';
	for (var i = y.length - 1; i >= 0; i--) {
		for (j = 0; j<y[i]; j++) {
			S = long_addition(S, x);
		}
		P = long_addition(P, S + '0'.repeat(y.length - 1 - i));
		S = '0';
	}
	return P;
}

function long_power(x, n) {
	P = '1';
	for (var i = 0; i<n; i++) {
		P = long_multiplication(P,x);
	}
	return P;
}

function long_rem(x, d) {
	if (x*1 < d) {return x;}
	var S = x[0];
	var i = 1;
	while (true) {
		if (S*1 >= d) {
			if ((S*1-Math.floor(S*1/d)*d) == '0') {
				x = x.substring(i);
			} else {
				x = (S*1-Math.floor(S*1/d)*d).toString() + x.substring(i);
			}	
			if (x == '') {
				return (S*1-Math.floor(S*1/d)*d).toString();
			} else {
				x = long_rem(x,d);
				return x;
			}
		} else {
			S += x[i];
			i = i+1;
		}
	}
}

function long_divide(x, d) {
	if (x*1 < d) {return '0';}
	var S = x[0];
	var q = '';
	for (var i = 1; i <= x.length; i++) {
		if (S*1 >= d) {
			q = q + Math.floor(S*1/d);
			x = (S*1-Math.floor(S*1/d)*d).toString() + x.substring(i);
			var first = firstGreaterThan(x,d);
			var numberOfSigns = (S*1-Math.floor(S*1/d)*d).toString().length;
			if (first>numberOfSigns) {
				q = q + '0'.repeat(first-numberOfSigns);
			}			
			if (x*1<d) {return q;}			
			q = q + long_divide(x,d);
			return q;
		} else {
			if (i<x.length) {S += x[i];}
		}
	}	
}

function firstGreaterThan(y,m) {
	var n = 0;
	var isGreater = 0;
	for (var i = 1; i <= y.length; i++) {
		if (y.substring(0,i)*1 >= m) {isGreater = 1; break;}
		n++;
	}
	return n;
}

function long_toHex(x) {
	var r = long_rem(x, 16);
	x = long_subtraction(x, r.toString());
	if (x == 0) {
		return toChar(r);
	}
	return long_toHex( long_divide(x, 16) ) + toChar(r);

	function toChar(n) {
		var alpha = "0123456789ABCDEF";
		return alpha.charAt(n);
	}
}

