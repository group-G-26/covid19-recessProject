#include<stdio.h>
#include<string.h>
#include<stdlib.h>
#include<unistd.h>
#include<sys/types.h>
#include<sys/socket.h>
#include<netinet/in.h>
#include <netdb.h>

void error(const char *msg){
    perror(msg);
    exit(0);
}
int main(int argc ,char *argv[]){
 int sockfd , portno , n, newsockfd;
 struct sockaddr_in serv_addr;
 struct hostent *server;

 char buffer[255];
 if (argc < 3){
     fprintf(stderr,"usage %s hostname port\n" , argv[0]);
     exit(1);
 }   
 portno = atoi(argv[2]);
 sockfd = socket(AF_INET , SOCK_STREAM ,0);
    if(sockfd<0)
        error("error opening socket");
    server = gethostbyname(argv[1]);
    if(server == NULL){
fprintf(stderr , "error,no such host");
    }    
bzero((char *) &serv_addr , sizeof(serv_addr));
serv_addr.sin_family = AF_INET;
bcopy((char *) server->h_addr , (char *)&serv_addr.sin_addr.s_addr , server->h_length);
serv_addr.sin_port = htons(portno);
if(connect(sockfd , (struct sockaddr *)&serv_addr,sizeof(serv_addr))<0)
error("Conection failed");
bzero(buffer,255);
  
    
    char name[255];
    char gender[255];
    char cat[255];
    char choice[255];
    char apl[255];
    char txt[] =".txt";
    char uname[255];
    char district[255];
    char temp[255];
    char c,cont,rem,con;
    int find_result = 0;
    int words=0;
    int count;
    FILE *f;
   	puts("========================================================");
	puts("                ***Ministry Of Health***   ");
	puts("========================================================");
	puts("Disclaimer!!!");
	puts("1.Access to this terminal is restricted to trained users.");
	puts("2.Access to this terminal is controlled and certified by the Administrator");
	puts("3.commands must be used as provided keeping in mind the case and symbols.");
	puts("4. use of commands in a way contrary to the stated will lead to fatal errors.");
	puts("do you wish to be reminded how the system works ? (y / n)");
	scanf("%c",&rem);
	if(rem=='y'){
	puts("reminder loading.....");
	puts("The command 'exit' ends session with the server");
	puts("press enter to continue......");
	scanf("%c",&cont);
	}
	else
	puts("terminal is loading......");
	scanf("%c",&cont);
    puts("* this is the health officer terminal*");
    
    puts("Enter your district: ");
    scanf("%s",district); 
    puts("Enter your username: ");
    scanf("%s",uname);
    write(sockfd,uname,255); 
    write(sockfd,district,255);
   
    printf("Welcome %s from %s \n",uname,district);
    
   puts("what would you like to do: ");
    a:
    scanf("%s", choice);
    if(strcmp(choice,"exit")==0){
   
     write(sockfd,choice,255);
     puts("thank you!!");
     goto e;
    }
    else if (strcmp(choice,"Check_status")==0){
    puts("you have chosen to check the file status");
    puts("please note this will end your session with the server");
    puts("do you want to continue ? (y / n)");
    scanf("%s",&con);
    if(con=='n'){
    puts("enter another command:");
    goto a;
    }
    write(sockfd, choice, 255);
    read(sockfd,&count,255);
     printf("the file has %d case(s) \n", count);
     puts("goodbye");
    
    goto e;
    
    }
    else if(strcmp(choice,"search")==0){
    write(sockfd,choice,255);
    scanf("%s",name);
    write(sockfd,name,255);
    read(sockfd,&find_result,255);
    printf("%d matches\n",find_result);
    for(int i=0;i<find_result;i++){
    read(sockfd, temp, 255);
    printf("%s ",temp);
    printf("read");
    }
    goto q;
    }
    else if (strcmp(choice,"addpatient")==0){
    write(sockfd, choice, 255); 
    n:scanf("%s",name);  						
    
    
    if(strstr(name,txt)){
     		printf("its a file\n");
     		f=fopen(name,"r");
     		if(f==NULL){
        printf("could not open file,Please try again.\n ");
        puts("type filename as saved.");
        goto n;
        return 0;
    }
    write(sockfd, name, 255);
     		for( words=0;(c=getc(f))!=EOF;words++){}
     		printf("size:%d\n",words);
     		write(sockfd, &words, sizeof(int));
     		rewind(f);
    		fread(buffer,sizeof(char),512,f);
       	write(sockfd,buffer,512);
       	printf("%s",buffer);
	printf("The file was sent successfully\n");
	goto q;
     		}
     else
     write(sockfd,name,255);								
    scanf("%s %s",gender,cat);
    write(sockfd,gender,255);
    write(sockfd,cat,255); 
    scanf("%s",apl);
    write(sockfd,apl,255);
    goto q;
   }
   else 
   {
   puts("invalid input, Please try again");
   goto a;
   }
   
  
    
q:
puts("To end session with server enter command 'exit'");
puts("Anything else? ");
goto a;

e:
close(sockfd);
return 0;



}
