import java.util.*;
class PhoneListAssignment
{
	static public boolean isConsistent(String []phones)
	{	for(int i=0;i<phones.length-1;i++)
		{	if(phones[i + 1].startsWith(phones[i]))
			return false;
        		}
		return true;
	}	
	static public  void main(String[] args)
	{	Scanner s=new Scanner(System.in);	
		int phoneNoCount=0;
		System.out.println("Enter  the test cases count");		
		int testCasesCount=s.nextInt();
		for(int i=0;i<testCasesCount;i++)
		{	System.out.println("Enter no.of pnone no's");
			phoneNoCount=s.nextInt();
			String phones[]=new String[phoneNoCount];
			for(int j=0;j<phoneNoCount;j++)
			{phones[j]=s.next();
			}
			Arrays.sort(phones);
			if(isConsistent(phones))
			System.out.println("YES");
			else
			System.out.println("NO");
		}
	}
}